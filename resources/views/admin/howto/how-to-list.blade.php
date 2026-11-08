@extends('admin.layouts.mainlayout')

@section('title', __('admin/menuleft.how_to_list'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="#">{{ __('admin/menuleft.how_to') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/menuleft.how_to_list') }}</li>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <div class="mb-2">
                <a href="{{ route('admin.howto.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    {{ __('admin/menuleft.how_to_create') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('admin/common.no') }}</th>
                            <th>{{ __('admin/howto.name_th') }}</th>
                            <th>{{ __('admin/howto.name_en') }}</th>
                            <th style="width: 120px;">{{ __('admin/howto.edit_th') }}</th>
                            <th style="width: 120px;">{{ __('admin/howto.edit_en') }}</th>
                            <th style="width: 160px;">{{ __('admin/common.created_at') }}</th>
                            <th style="width: 160px;">{{ __('admin/common.updated_at') }}</th>
                            <th style="width: 80px;">{{ __('admin/common.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($howTos as $index => $howTo)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $howTo->how_to_name }}</td>
                                <td>{{ $howTo->translation->how_to_name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.howto.edit', $howTo) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if ($howTo->filename)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('howto/'.$howTo->filename) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="{{ __('admin/howto.download_pdf') }}">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($howTo->translation)
                                        <a href="{{ route('admin.howto.edit', $howTo->translation) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        @if ($howTo->translation->filename)
                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('howto/'.$howTo->translation->filename) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="{{ __('admin/howto.download_pdf') }}">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $howTo->created_at?->format('d/m/Y H:i') }}</td>
                                <td>{{ $howTo->updated_at?->format('d/m/Y H:i') }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteHowToModal{{ $howTo->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    {{ __('admin/common.no_data') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    @foreach ($howTos as $howTo)
        <div class="modal fade" id="deleteHowToModal{{ $howTo->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('admin/common.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('admin/common.confirm_delete_message') }}
                        <div class="fw-bold mt-2">{{ $howTo->how_to_name }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('admin/common.cancel') }}
                        </button>
                        <form method="POST" action="{{ route('admin.howto.destroy', $howTo) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                {{ __('admin/common.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
