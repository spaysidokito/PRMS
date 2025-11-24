<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourceFormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forms = [
            // SOA Forms
            [
                'category' => 'soa',
                'subcategory' => 'Organization Forms',
                'name' => 'Members & Officers Info Sheet',
                'template_filename' => 'MEMBERS_OFFICERS_INFOSHEET 2025',
                'display_order' => 1,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Organization Forms',
                'name' => 'Adviser Info Sheet',
                'template_filename' => 'ADVISER_INFOSHEET',
                'display_order' => 2,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Organization Forms',
                'name' => 'Cover Sheet for Organizations',
                'template_filename' => 'COVER-SHEET-FOR-NEW-AND-OLD-ORGANIZATIONS',
                'display_order' => 3,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Activity Forms',
                'name' => 'Calendar of Activities',
                'template_filename' => 'CALENDAR-OF-ACTIVITIES FINAL2025',
                'display_order' => 1,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Activity Forms',
                'name' => 'Activity Application (On-campus)',
                'template_filename' => 'APPLI_INCAMPUS_2025',
                'display_order' => 2,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Activity Forms',
                'name' => 'Activity Application (Off-campus)',
                'template_filename' => 'APPLI_OFFCAMPUS_2025',
                'display_order' => 3,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Documentation Forms',
                'name' => 'Waiver Form',
                'template_filename' => 'WAIVER',
                'display_order' => 1,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Documentation Forms',
                'name' => 'Narrative Format',
                'template_filename' => 'FORMAT_NARRATIVE',
                'display_order' => 2,
                'is_active' => true
            ],
            [
                'category' => 'soa',
                'subcategory' => 'Documentation Forms',
                'name' => 'Members Certification',
                'template_filename' => 'LIST OF MEMBERS CERTIFY BY ORG ADVISER',
                'display_order' => 3,
                'is_active' => true
            ],

            // GTC Forms
            [
                'category' => 'gtc',
                'subcategory' => 'Testing & Application Forms',
                'name' => 'Application for SACLI Entrance Exam',
                'template_filename' => 'Application for SACLI Entrance Exam',
                'display_order' => 1,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Testing & Application Forms',
                'name' => 'Certificate of Good Moral Request Form',
                'template_filename' => 'Certificate of Good Moral Request Form',
                'display_order' => 2,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Testing & Application Forms',
                'name' => 'Instructor\'s Referral Form',
                'template_filename' => 'INSTRUCTOR\'S REFERRAL FORM',
                'display_order' => 3,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Counseling Forms',
                'name' => 'Counseling Call Slip',
                'template_filename' => 'COUNSELING CALL SLIP',
                'display_order' => 1,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Counseling Forms',
                'name' => 'Counseling Appointment QR',
                'template_filename' => 'counseling appointment qr',
                'display_order' => 2,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Counseling Forms',
                'name' => 'GTC Exit Interview Form for Graduating Students',
                'template_filename' => 'GTC Exit Interview Form for Graduating Students',
                'display_order' => 3,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Evaluation & Assessment Forms',
                'name' => 'Online Student-Faculty Evaluation Tool',
                'template_filename' => 'Online Student-Faculty Evaluation Tool',
                'display_order' => 1,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Evaluation & Assessment Forms',
                'name' => 'GTC After Activity Evaluation Tool',
                'template_filename' => 'GTC After activity evaluation Tool',
                'display_order' => 2,
                'is_active' => true
            ],
            [
                'category' => 'gtc',
                'subcategory' => 'Evaluation & Assessment Forms',
                'name' => 'Satisfaction Evaluation Survey on SACLI Guidance Services',
                'template_filename' => 'SATISFACTION EVALUATION SURVEY ON SACLI GUIDANCE SERVICES booklet style',
                'display_order' => 3,
                'is_active' => true
            ],
        ];

        foreach ($forms as $form) {
            \App\Models\ResourceForm::updateOrCreate(
                [
                    'category' => $form['category'],
                    'name' => $form['name']
                ],
                $form
            );
        }
    }
}
