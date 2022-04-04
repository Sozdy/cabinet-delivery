<div class="text-justify">
    <div class="modal" tabindex="-1" role="dialog" id="{{ $id_prefix }}-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-custom text-light">
                    <h5 class="modal-title">@yield('title')</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					@yield('modal-body')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Нет</button>
                    <button type="submit" class="btn btn-custom" onclick="@yield('action')">Да</button>
                </div>
            </div>
        </div>
    </div>
</div>
