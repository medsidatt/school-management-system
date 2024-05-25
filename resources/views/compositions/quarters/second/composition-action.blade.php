<div class="btn-group" role="group" aria-label="">
    <button type="button" class="btn btn-outline-primary"
            onclick="showFunc({{$student_id}}, {{$class_id}})"
            style="padding: 1px">
        <a href="javascript:void(0)" class="delete btn btn-primary">
            <i class="bi bi-eye-fill"></i>
        </a>
    </button>
    <button type="button" class="btn btn-outline-primary"
            onclick="printFunc({{$student_id}}, {{$class_id}})"
            style="padding: 1px">
        <a href="javascript:void(0)" class="delete btn btn-danger">
            <i class="bi bi-printer-fill"></i>
        </a>
    </button>

</div>
