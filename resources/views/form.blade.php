<form action="" method="POST" id="userForm">
    @csrf

    {{-- Nama --}}
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
             placeholder="Masukan nama anda" value="{{ old('name') }}">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Phone Number --}}
    <div class="mb-3">
      <label class="form-label">No HP</label>
      <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
             placeholder="Masukan no hp" value="{{ old('phone_number') }}">
      @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

     {{-- Email --}}
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
             placeholder="Masukan Email" value="{{ old('email') }}">
      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Tanggal Lahir --}}
    <div class="mb-3">
      <label class="form-label">Tanggal Lahir</label>
      <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
             value="{{ old('dob') }}">
      @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Kewarganegaraan --}}
    <div class="mb-4">
    <label class="form-label">Kewarganegaraan</label>
    <select name="nationality_id" class="form-select @error('nationality_id') is-invalid @enderror" required>
        <option value="">-- Pilih Kewarganegaraan --</option>
        @foreach($nationality as $nat)
            <option value="{{ $nat->id }}" {{ old('nationality_id') == $nat->id ? 'selected' : '' }}>
                {{ $nat->name }}
            </option>
        @endforeach
    </select>
    @error('nationality_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Keluarga --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
      <label class="form-label m-0">Keluarga</label>
      <a href="#" id="addFamilyRow" class="small text-decoration-none">+ Tambah Keluarga</a>
    </div>

    <div class="table-responsive">
      <table class="table align-middle" id="familyTable">
        <thead>
          <tr>
            <th style="width:55%">Nama</th>
            <th style="width:35%">Tanggal Lahir</th>
            <th style="width:10%"></th>
          </tr>
        </thead>
        <tbody>
          @php
            $families = old('families', [['name'=>'','dob'=>'']]);
          @endphp
          @foreach ($families as $i => $fam)
            <tr>
              <td>
                <input type="text"
                       name="families[{{ $i }}][name]"
                       class="form-control @error("families.$i.name") is-invalid @enderror"
                       placeholder="Masukan Nama"
                       value="{{ old("families.$i.name", $fam['name']) }}">
                @error("families.$i.name") <div class="invalid-feedback">{{ $message }}</div> @enderror
              </td>
              <td>
                <input type="date"
                       name="families[{{ $i }}][dob]"
                       class="form-control @error("families.$i.dob") is-invalid @enderror"
                       value="{{ old("families.$i.dob", $fam['dob']) }}">
                @error("families.$i.dob") <div class="invalid-feedback">{{ $message }}</div> @enderror
              </td>
              <td class="text-end">
                <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    <br>
  </form>