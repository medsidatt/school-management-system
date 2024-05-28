<div class="btn-group" role="group" aria-label="">
    <button type="button" class="btn btn-outline-primary" style="padding: 1px;">
        <a href="{{ route('teachers.show', $id) }}" data-toggle="tooltip" data-original-title="view"
           class="edit btn btn-success">
            <i
                class="bi bi-eye-fill"></i>
        </a>
    </button>
    <button type="button" class="btn btn-outline-primary" style="padding: 1px;">
        <a href="{{ route('teachers.edit', $id) }}" data-toggle="tooltip"
           data-original-title="Edit" class="edit btn btn-primary">
            <i class="bi bi-pencil-fill"></i>
        </a>
    </button>
    <button type="button" class="btn btn-outline-primary" onclick="deleteFunc({{ $id }})"
            style="padding: 1px;">
        <a data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
            <i class="bi bi-trash-fill"></i>
        </a>
    </button>

</div>
