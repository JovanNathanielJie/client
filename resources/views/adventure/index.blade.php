@extends('layout.main')

@section('content')
<div class="container py-5">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; border: none;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="text-center mb-5">
        <h2 class="fw-bold text-gradient">🗺️ Our Adventure 🗺️</h2>
        <p class="text-muted" style="font-size: 1.1rem;">Rencana petualangan indah yang akan kita lalui bersama</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Add New Adventure Form -->
            <div class="card shadow-lg border-0 mb-4" style="border-radius: 20px; overflow: hidden; background: linear-gradient(135deg, #f8f9ff 0%, #eef2ff 100%);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-plus-circle me-2" style="color: #667eea;"></i>
                        Tambah Petualangan Baru
                    </h5>
                    <form action="{{ route('adventure.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-600">Kegiatan</label>
                                <input type="text" class="form-control form-control-lg" name="kegiatan"
                                       placeholder="Contoh: Liburan ke Bali" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef;">
                                @error('kegiatan')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-600">Rencana Kapan</label>
                                <input type="text" class="form-control form-control-lg" name="rencana_kapan"
                                       placeholder="Contoh: 15 Juni 2026 atau Juni 2026 atau 2026" required
                                       style="border-radius: 10px; border: 2px solid #e9ecef;">
                                @error('rencana_kapan')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600">Deskripsi Kegiatan</label>
                            <textarea class="form-control form-control-lg" name="deskripsi_kegiatan"
                                      rows="3" placeholder="Deskripsikan kegiatan ini..." required
                                      style="border-radius: 10px; border: 2px solid #e9ecef;"></textarea>
                            @error('deskripsi_kegiatan')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-save me-2"></i> Simpan Kegiatan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Adventures Table -->
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-0">
                    @if($adventures->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 adventure-table">
                                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <tr>
                                        <th style="width: 5%; text-align: center; padding: 20px 10px;">No</th>
                                        <th style="width: 20%; padding: 20px;">Kegiatan</th>
                                        <th style="width: 18%; padding: 20px;">Rencana Kapan</th>
                                        <th style="width: 37%; padding: 20px;">Deskripsi Kegiatan</th>
                                        <th style="width: 20%; text-align: center; padding: 20px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($adventures as $index => $adventure)
                                        <tr class="adventure-row" data-adventure-id="{{ $adventure->id }}">
                                            <td style="text-align: center; padding: 20px 10px; font-weight: bold; color: #667eea;">
                                                {{ $index + 1 }}
                                            </td>
                                            <td style="padding: 20px; font-weight: 600; color: #333;">
                                                {{ $adventure->kegiatan }}
                                            </td>
                                            <td style="padding: 20px;">
                                                <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 15px; font-size: 0.95rem;">
                                                    📅 {{ $adventure->rencana_kapan }}
                                                </span>
                                            </td>
                                            <td style="padding: 20px; color: #666; line-height: 1.6;">
                                                {{ Str::limit($adventure->deskripsi_kegiatan, 60) }}
                                            </td>
                                            <td style="padding: 20px; text-align: center;">
                                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $adventure->id }}"
                                                        style="border-radius: 8px;">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('adventure.destroy', $adventure->id) }}" method="POST"
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 8px;">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $adventure->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content" style="border-radius: 15px; border: none;">
                                                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                                                        <h5 class="modal-title fw-bold">Edit Kegiatan</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('adventure.update', $adventure->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body p-4">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-600">Kegiatan</label>
                                                                <input type="text" class="form-control form-control-lg" name="kegiatan"
                                                                       value="{{ $adventure->kegiatan }}" required
                                                                       style="border-radius: 10px; border: 2px solid #e9ecef;">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-600">Rencana Kapan</label>
                                                                <input type="text" class="form-control form-control-lg" name="rencana_kapan"
                                                                       value="{{ $adventure->rencana_kapan }}" required
                                                                       style="border-radius: 10px; border: 2px solid #e9ecef;">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-600">Deskripsi Kegiatan</label>
                                                                <textarea class="form-control form-control-lg" name="deskripsi_kegiatan"
                                                                          rows="4" required
                                                                          style="border-radius: 10px; border: 2px solid #e9ecef;">{{ $adventure->deskripsi_kegiatan }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer" style="border-top: 1px solid #e9ecef;">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>
                            <p class="text-muted mb-0" style="font-size: 1.1rem;">Belum ada petualangan yang direncanakan</p>
                            <p class="text-muted small">Mulai dengan menambahkan kegiatan baru di atas! ✨</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics Section -->
            @if($adventures->count() > 0)
                <div class="row mt-5 g-3">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0" style="border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <div class="card-body text-center py-4">
                                <h3 class="fw-bold" style="font-size: 2.5rem;">{{ $adventures->count() }}</h3>
                                <p class="mb-0">Petualangan Direncanakan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0" style="border-radius: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                            <div class="card-body text-center py-4">
                                <h3 class="fw-bold" style="font-size: 2.5rem;">∞</h3>
                                <p class="mb-0">Kenangan Terindah</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0" style="border-radius: 15px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                            <div class="card-body text-center py-4">
                                <h3 class="fw-bold" style="font-size: 2.5rem;">💕</h3>
                                <p class="mb-0">Bersama Selamanya</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .adventure-table {
        font-size: 1rem;
    }

    .adventure-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .adventure-row:hover {
        background-color: #f8f9ff;
        transform: translateX(5px);
        box-shadow: -5px 0 15px rgba(102, 126, 234, 0.1);
    }

    .adventure-row:last-child {
        border-bottom: none;
    }

    .badge {
        font-weight: 600;
        border-radius: 8px;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #333;
    }

    .btn-warning:hover {
        background-color: #ffb300;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    @media (max-width: 768px) {
        .adventure-table thead {
            display: none;
        }

        .adventure-table tbody,
        .adventure-table tr,
        .adventure-table td {
            display: block;
            width: 100%;
        }

        .adventure-row {
            border: 1px solid #e9ecef;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }

        .adventure-row td {
            padding: 15px !important;
            text-align: left !important;
            position: relative;
            padding-left: 140px !important;
        }

        .adventure-row td:first-child {
            padding-left: 15px !important;
        }

        .adventure-row td:first-child::before {
            display: none;
        }

        .adventure-row td:nth-child(2)::before {
            content: "Kegiatan: ";
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #667eea;
            width: 120px;
        }

        .adventure-row td:nth-child(3)::before {
            content: "Rencana: ";
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #667eea;
            width: 120px;
        }

        .adventure-row td:nth-child(4)::before {
            content: "Deskripsi: ";
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #667eea;
            width: 120px;
        }

        .adventure-row td:nth-child(5) {
            padding-top: 10px !important;
        }
    }
</style>
@endsection
