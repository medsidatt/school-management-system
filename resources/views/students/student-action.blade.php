<div class="btn-group" role="group" aria-label="">
    <button type="button" class="btn btn-outline-primary p-1">
        <a href="{{ route('students.view', $id) }}" data-toggle="tooltip" data-original-title="view"
           class="edit btn btn-success">
            <i
                class="bi bi-eye-fill"></i>
        </a>
    </button>
    <button type="button" class="btn btn-outline-primary p-1">
        <a href="{{ route('students.edit', $id) }}" data-toggle="tooltip"
           data-original-title="Edit" class="edit btn btn-primary">
            <i class="bi bi-pencil-fill"></i>
        </a>
    </button>
    <button type="button" class="btn btn-outline-primary p-1" onclick="deleteFunc({{ $id }})">
        <a data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
            <i class="bi bi-trash-fill"></i>
        </a>
    </button>

</div>
