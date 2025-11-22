@php use Illuminate\Pagination\LengthAwarePaginator; @endphp
@if ($paginator instanceof LengthAwarePaginator)
    <div class="d-flex justify-content-center">
        {{ $paginator->links('vendor.pagination.bootstrap-5') }}
    </div>
@else
    <p>Dữ liệu không được phân trang</p>
@endif
