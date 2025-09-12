

<form action="{{ route('employeeDocumentSave', $document->id ?? '') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="employee_id" value="{{ isset($employee_id) ? $employee_id : '' }}">
    <div class="modal-header">
        <h5 class="modal-title">{{ isset($document) ? 'Edit Document' : 'Add Document' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Document Type</label>
            <select name="document_name" class="form-control" required>
                <option value="" disabled selected>-- Select Document Type --</option>
                @foreach(\App\Enums\DocumentType::cases() as $type)
                    <option value="{{ $type->value }}" 
                        {{ (isset($document) && $document->document_name == $type->value) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" name="document" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">{{ isset($document) ? 'Update Document' : 'Save Document' }}</button>
    </div>
</form>
