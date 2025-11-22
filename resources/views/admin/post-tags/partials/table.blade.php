@foreach($tags as $index => $tag)
    <tr data-id="{{ $tag->id }}">
        <td>{{ $tags->firstItem() + $index }}</td>
        <td>
            <strong>{{ $tag->name ?? '' }}</strong>
            <br><small class="text-muted">Slug: {{ $tag->slug ?? '' }}</small>
        </td>
        <td>{{ Str::limit($tag->description ?? '', 80) }}</td>
        <td>
            <select class="form-select form-select-sm status-select" 
                    data-tag-id="{{ $tag->id }}" 
                    data-current-status="{{ $tag->is_active ? '1' : '0' }}"
                    data-status-type="post-tags">
                <option value="0" {{ !$tag->is_active ? 'selected' : '' }}>
                    Vô hiệu
                </option>
                <option value="1" {{ $tag->is_active ? 'selected' : '' }}>
                    Kích hoạt
                </option>
            </select>
        </td>
        <td>
            <select class="form-select form-select-sm featured-select" 
                    data-tag-id="{{ $tag->id }}" 
                    data-current-featured="{{ $tag->is_featured ? '1' : '0' }}"
                    data-featured-type="post-tags">
                <option value="0" {{ !$tag->is_featured ? 'selected' : '' }}>
                    Không nổi bật
                </option>
                <option value="1" {{ $tag->is_featured ? 'selected' : '' }}>
                    Nổi bật
                </option>
            </select>
        </td>
        <td>
            <div class="action-buttons">
                @can('access_users')
                    <button type="button" class="btn-action btn-edit" title="Chỉnh sửa"
                            onclick="openEditTagModal({{ $tag->id }})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn-action btn-delete" title="Xóa" onclick="deleteData('/admin/post-tags/{{ $tag->id }}', 'DELETE')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                @endcan
            </div>
        </td>
    </tr>
@endforeach
