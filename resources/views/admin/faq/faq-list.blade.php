@extends('admin.layouts.mainlayout')

@section('title', __('admin/menuleft.faq_list'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="#">{{ __('admin/menuleft.faq') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/menuleft.faq_list') }}</li>
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
                <a href="{{ route('admin.faq.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    {{ __('admin/menuleft.faq_create') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">{{ __('admin/common.no') }}</th>
                            <th>{{ __('admin/faq.question_th') }}</th>
                            <th>{{ __('admin/faq.question_en') }}</th>
                            <th style="width: 100px;">{{ __('admin/faq.edit_th') }}</th>
                            <th style="width: 100px;">{{ __('admin/faq.edit_en') }}</th>
                            <th style="width: 160px;">{{ __('admin/common.created_at') }}</th>
                            <th style="width: 160px;">{{ __('admin/common.updated_at') }}</th>
                            <th style="width: 80px;">{{ __('admin/common.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faqs as $index => $faq)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $faq->faq_name }}</td>
                                <td>{{ $faq->translation->faq_name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.faq.edit', $faq) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                                <td>
                                    @if ($faq->translation)
                                        <a href="{{ route('admin.faq.edit', $faq->translation) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $faq->created_at?->format('d/m/Y H:i') }}</td>
                                <td>{{ $faq->updated_at?->format('d/m/Y H:i') }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteFaqModal{{ $faq->id }}">
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

    @foreach ($faqs as $faq)
        <div class="modal fade" id="deleteFaqModal{{ $faq->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('admin/common.confirm_delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('admin/common.confirm_delete_message') }}
                        <div class="fw-bold mt-2">{{ $faq->faq_name }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('admin/common.cancel') }}
                        </button>
                        <form method="POST" action="{{ route('admin.faq.destroy', $faq) }}">
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
