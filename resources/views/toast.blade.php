<div id="{{ $id }}" class="toast" style="position: absolute; top: 0; right: 0; z-index:1070;" data-delay='2000'>
	<div class="toast-header bg-{{ $type }} text-body">
		  <strong class="mr-auto">{{ $title }}</strong>
		  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
				<span aria-hidden="true">&times;</span>
		  </button>
	</div>
	<div class="toast-body bg-white">
		{{ $message }}
	</div>
</div>