@foreach($categories as $index => $category)
    <tr data-id="{{ $category->id }}">
        <td>{{ $categories->firstItem() + $index }}</td>
        <td>
            <strong>{{ $category->name ?? '' }}</strong>
            @if($category->parent)
                <br><small class="text-muted">Cha: {{ $category->parent->name }}</small>
            @endif
        </td>
        <td>{{ Str::limit($category->description ?? '', 80) }}</td>
        <td>
            <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">
                {{ $category->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
            </span>
        </td>
        <td>
            <div class="action-buttons">
                @can('access_users')
                    <button type="button" class="btn-action btn-edit" title="Chỉnh sửa"
                            onclick="openEditPostCategoryModal({{ $category->id }})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn-action btn-delete" title="Xóa" onclick="deletePostCategory({{ $category->id }})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                @endcan
            </div>
        </td>
    </tr>
@endforeach
