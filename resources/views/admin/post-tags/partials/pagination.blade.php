@if($tags->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $tags->links() }}
    </div>
@endif
