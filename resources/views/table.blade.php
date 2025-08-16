{{-- === LIST CUSTOMER === --}}
<div class="card shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="fw-semibold">Daftar Customer</span>
    <span class="text-muted small">Total: {{ $customer->total() }}</span>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width:6%">No</th>
            <th style="width:22%">Name</th>
            <th style="width:18%">Phone</th>
            <th style="width:24%">Email</th>
            <th style="width:18%">Nationality</th>
            <th style="width:12%" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($customer as $cust)
            <tr>
              <td>{{ ($i ?? 0) + $loop->iteration }}</td>
              <td class="fw-medium">{{ $cust->name }}</td>
              <td>{{ $cust->phone_number }}</td>
              <td>
                <a href="mailto:{{ $cust->email }}" class="text-decoration-none">
                  {{ $cust->email }}
                </a>
              </td>
              <td>
                <span class="badge bg-secondary-subtle text-secondary-emphasis">
                  {{ $cust->nationality->name ?? '-' }}
                </span>
              </td>
              <td class="text-center">
                <button type="button"
                        class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#familyModal{{ $cust->id }}">
                  Detail
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">
                Belum ada data customer.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($customer->hasPages())
    <div class="card-footer d-flex justify-content-end">
      {{ $customer->links() }}
    </div>
  @endif
</div>

{{-- === MODALS: render di luar table agar markup valid === --}}
@foreach ($customer as $cust)
  <div class="modal fade" id="familyModal{{ $cust->id }}" tabindex="-1"
       aria-labelledby="familyModalLabel{{ $cust->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="familyModalLabel{{ $cust->id }}">
            Keluarga: {{ $cust->name }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"
                  aria-label="Close"></button>
        </div>

        <div class="modal-body">
          @if($cust->familyLists->isEmpty())
            <div class="text-muted">Belum ada data keluarga.</div>
          @else
            <div class="table-responsive">
              <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width:60%">Nama</th>
                    <th style="width:40%">Tanggal Lahir</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($cust->familyLists as $fam)
                    <tr>
                      <td>{{ $fam->name }}</td>
                      <td>{{ \Carbon\Carbon::parse($fam->dob)->format('d/m/Y') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
