<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage SOA Forms') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Back Button and Add New Form Button -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('resources.soa') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to SOA
                </a>
                <button onclick="openAddModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>Add New Form
                </button>
            </div>

            <!-- Forms List by Subcategory -->
            @foreach($formsBySubcategory as $subcategory => $forms)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $subcategory }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Form Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Template File</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($forms as $form)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $form->display_order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $form->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $form->template_filename ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="openEditModal({{ $form->id }})" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button onclick="openUploadModal({{ $form->id }})" class="text-green-600 hover:text-green-900 mr-3">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                        <form action="{{ route('resources.forms.destroy', $form->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this form?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="formModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-4">Add New Form</h3>
                <form id="formModalForm" method="POST">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
                        <select name="subcategory" id="subcategory" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="Organization Forms">Organization Forms</option>
                            <option value="Activity Forms">Activity Forms</option>
                            <option value="Documentation Forms">Documentation Forms</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Form Name</label>
                        <input type="text" name="name" id="formName" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template Filename</label>
                        <input type="text" name="template_filename" id="templateFilename" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g., MEMBERS_OFFICERS_INFOSHEET 2025">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                        <input type="number" name="display_order" id="displayOrder" class="w-full border-gray-300 rounded-md shadow-sm" value="0" required>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Form Template</h3>
                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_id" id="uploadFormId">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select File (DOC, DOCX, PDF)</label>
                        <input type="file" name="template_file" id="templateFile" accept=".doc,.docx,.pdf" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        <p class="text-xs text-gray-500 mt-1">Max file size: 10MB</p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeUploadModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-upload mr-2"></i>Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const forms = @json($allForms);

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Form';
            document.getElementById('formModalForm').action = '{{ route("resources.forms.store") }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('formName').value = '';
            document.getElementById('templateFilename').value = '';
            document.getElementById('displayOrder').value = '0';
            document.getElementById('subcategory').value = 'Organization Forms';
            document.getElementById('formModal').classList.remove('hidden');
        }

        function openEditModal(formId) {
            const form = forms.find(f => f.id === formId);
            if (!form) return;

            document.getElementById('modalTitle').textContent = 'Edit Form';
            document.getElementById('formModalForm').action = `/resources/forms/${formId}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('formName').value = form.name;
            document.getElementById('templateFilename').value = form.template_filename || '';
            document.getElementById('displayOrder').value = form.display_order;
            document.getElementById('subcategory').value = form.subcategory;
            document.getElementById('formModal').classList.remove('hidden');
        }

        function openUploadModal(formId) {
            document.getElementById('uploadFormId').value = formId;
            document.getElementById('uploadForm').action = `/resources/forms/${formId}/upload`;
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('formModal').classList.add('hidden');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('templateFile').value = '';
        }
    </script>
</x-app-layout>
