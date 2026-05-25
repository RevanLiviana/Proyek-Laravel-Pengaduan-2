<div class="table-responsive table-wrapper" id="dataTableWrap">
    <table class="table" id="dataTable">
        <thead>
            <tr>
                <th style="width:50px;">NO</th>
                <th>NAMA KATEGORI</th>
                <th>IKON</th>
                <th>DESKRIPSI</th>
                <th>LAPORAN</th>
                <th>STATUS</th>
                <th style="width:100px;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $i => $k)
            <tr class="data-row">
                <td class="text-muted">{{ $kategoris->firstItem() + $i }}</td>
                <td class="fw-semibold">{{ $k->nama_kategori }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded"
                              style="width:32px;height:32px;background:#EEF2FF;color:#3B5BDB;font-size:16px;">
                            <i class="bi bi-{{ $k->ikon ?? 'tag' }}"></i>
                        </span>
                        <code style="font-size:11px;color:#64748B;">{{ $k->ikon ?? 'tag' }}</code>
                    </div>
                </td>
                <td class="text-muted">{{ $k->deskripsi ?? '-' }}</td>
                <td>
                    <span class="fw-semibold">{{ $k->laporan_count }}</span>
                    <span class="text-muted" style="font-size:12px;"> laporan</span>
                </td>
                <td>
                    <span class="badge-status {{ $k->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                        {{ ucfirst($k->status) }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn-action edit" title="Edit"
                                onclick="openEdit({{ $k->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-action del" title="Hapus"
                                onclick="deleteKategori({{ $k->id }}, '{{ addslashes($k->nama_kategori) }}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="icon"><i class="bi bi-tag-fill"></i></div>
                        <h6>Belum ada kategori</h6>
                        <p>Klik tombol Tambah Kategori untuk memulai</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex align-items-center justify-content-between px-4 py-3">
    <small class="text-muted">
        Menampilkan {{ $kategoris->firstItem() ?? 0 }}–{{ $kategoris->lastItem() ?? 0 }}
        dari {{ $kategoris->total() }} data
    </small>
    {{ $kategoris->links('vendor.pagination.custom') }}
</div>