@if($categories->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $categories->links() }}
    </div>
@endif
