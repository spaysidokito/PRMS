"""

No SDA Automation - Completely blocks Strongly Disagree responses

Forces only SA, A, and D responses

"""

import requests

import re

import random

import time

def submit_once(form_url, run_number):

    """Submit form once with NO SDA ever"""

    try:

        # Get the form

        response = requests.get(form_url, timeout=10)

        html = response.text



        # Find entry fields

        patterns = [

            r'name="(entry\.\d+)"',

            r"name='(entry\.\d+)'",

            r'entry\.(\d+)',

            r'"entry\.(\d+)"'

        ]



        all_entries = []

        for pattern in patterns:

            matches = re.findall(pattern, html)

            if pattern in [r'entry\.(\d+)', r'"entry\.(\d+)"']:

                matches = [f'entry.{match}' for match in matches]

            all_entries.extend(matches)



        unique_entries = list(set(all_entries))



        if len(unique_entries) == 0:

            return False, "No entries found"



        # Get form action URL

        form_id = form_url.split('/d/e/')[1].split('/')[0]

        action_url = f"https://docs.google.com/forms/d/e/{form_id}/formResponse"



        # Prepare data with STRICT no-SDA policy

        data = {}

        sa_count = 0

        a_count = 0

        d_count = 0



        for entry in unique_entries:

            # Find actual values in HTML

            entry_section = ""

            entry_pos = html.find(entry)

            if entry_pos != -1:

                start = max(0, entry_pos - 2000)

                end = min(len(html), entry_pos + 2000)

                entry_section = html[start:end]



            value_patterns = [

                r'value="([^"]*)"',

                r"value='([^']*)'",

                r'data-value="([^"]*)"',

            ]



            values = []

            for pattern in value_patterns:

                matches = re.findall(pattern, entry_section, re.IGNORECASE)

                values.extend(matches)



            # STRICT filtering - remove ALL variations of "Strongly Disagree"

            filtered_values = []

            for v in values:

                v_clean = v.strip()

                if (v_clean and len(v_clean) > 0 and

                    v_clean not in ['', '0', '1', 'on'] and

                    'strongly disagree' not in v_clean.lower() and

                    'sda' not in v_clean.lower()):

                    filtered_values.append(v_clean)



            values = list(set(filtered_values))



            # If no values found, use only SA, A, D (NO SDA)

            if not values:

                values = ["Strongly Agree", "Agree", "Disagree"]  # Only 3 options



            # FORCE selection to only use SA, A, or D

            rand_val = random.random()

            if rand_val < 0.75:

                # 75% Strongly Agree

                # Find SA option

                sa_option = None

                for val in values:

                    if "strongly agree" in val.lower() or "sa" in val.lower():

                        sa_option = val

                        break

                selected_value = sa_option if sa_option else values[-1]

                sa_count += 1



            elif rand_val < 0.97:

                # 22% Agree (but NOT strongly agree)

                # Find A option

                a_option = None

                for val in values:

                    if ("agree" in val.lower() and "strongly" not in val.lower()) or val.lower() == "a":

                        a_option = val

                        break

                selected_value = a_option if a_option else (values[-2] if len(values) > 1 else values[0])

                a_count += 1



            else:

                # 3% Disagree (but NEVER strongly disagree)

                # Find D option (but not SDA)

                d_option = None

                for val in values:

                    if ("disagree" in val.lower() and "strongly" not in val.lower()) or val.lower() == "d":

                        d_option = val

                        break

                selected_value = d_option if d_option else (values[0] if len(values) > 0 else "Disagree")

                d_count += 1



            # DOUBLE CHECK - never allow SDA

            if "strongly disagree" in selected_value.lower():

                selected_value = "Agree"  # Force to positive if SDA somehow gets through

                a_count += 1

                d_count -= 1



            data[entry] = selected_value



        # Submit

        headers = {

            'Content-Type': 'application/x-www-form-urlencoded',

            'Referer': form_url,

            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'

        }



        submit_response = requests.post(action_url, data=data, headers=headers, allow_redirects=True, timeout=10)



        # Calculate percentages

        total = len(unique_entries)

        sa_pct = (sa_count / total * 100) if total > 0 else 0

        a_pct = (a_count / total * 100) if total > 0 else 0

        d_pct = (d_count / total * 100) if total > 0 else 0



        status_msg = f"SA:{sa_pct:.0f}% A:{a_pct:.0f}% D:{d_pct:.0f}% SDA:0%"



        # HTTP 200 = SUCCESS

        success = submit_response.status_code == 200



        return success, status_msg



    except Exception as e:

        return False, f"Error: {str(e)[:40]}..."

def main():

    form_url = "https://docs.google.com/forms/d/e/1FAIpQLSdZBQGNn4G7B-X0Y-hjlxplEhQ8qyQONdF496OKnN3LyIEYZg/viewform?usp=header"



    print("🚀 NO SDA - 50 Ultra Positive Submissions")

    print("📊 Target: 75% SA, 22% A, 3% D, 0% SDA (ZERO Strongly Disagree)")

    print("🚫 Strongly Disagree is COMPLETELY BLOCKED")

    print("=" * 80)



    successful = 0

    failed = 0



    for run in range(1, 51):

        success, message = submit_once(form_url, run)



        if success:

            status = "✅ SUCCESS"

            successful += 1

        else:

            status = "❌ FAILED"

            failed += 1



        print(f"Run #{run:2d}/50 | {status} | {message}")



        # Delay between submissions

        if run < 50:

            time.sleep(random.uniform(1.0, 2.5))



    # Final summary

    print("\n" + "=" * 80)

    print("📈 FINAL RESULTS:")

    print(f"✅ Successful submissions: {successful}/50 ({successful/50*100:.1f}%)")

    print(f"❌ Failed submissions: {failed}/50 ({failed/50*100:.1f}%)")

    print(f"📊 Response pattern: 75% SA, 22% A, 3% D, 0% SDA")

    print("🚫 ZERO 'Strongly Disagree' responses guaranteed!")

    print("=" * 80)

if _name_ == "_main_":

    main()
