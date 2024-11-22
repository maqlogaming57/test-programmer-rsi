<div class="container">
    @if ($errors->any())
        <div class="pt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>      
    @endif
    @if (session()->has('message'))
    <div class="pt-3">
        <div class="alert alert-success">
            {{ session('message')  }}
        </div>
    </div>
        
    @endif
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form>
                <div class="mb-3 row">
                    <label for="todo" class="col-sm-2 col-form-label">Todo</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="todo">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" wire:model="tanggal">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jam" class="col-sm-2 col-form-label">jam</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" wire:model="jam">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status" wire:model="status">
                            <option value="">Pilih Status</option>
                            <option value="belum">Belum</option>
                            <option value="sedang">Sedang</option>
                            <option value="sudah">Sudah</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        @if ($updateData == false)
                            <button type="button" class="btn btn-primary" name="submit" wire:click="store()">SIMPAN</button>
                        @else
                            <button type="button" class="btn btn-primary" name="submit" wire:click="update()">Update</button>
                        @endif
                        <button type="button" class="btn btn-secondary" name="submit" wire:click="clear()">Clear</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- AKHIR FORM -->

        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>RSI HARAPAN ANDA</h1>
            <div class="p-3 pt-3">
                <input type="text" class="form-control mb-3 w-25" placeholder="Search..." wire:model.live="katakunci">
            </div>
            @if ($employee_selected_id)
                <a wire:click="delete_confirmation('')" class="btn btn-danger btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Del {{ count($employee_selected_id) }} data</a>
            @endif
            {{ $dataEmployees->links() }}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4">Todo</th>
                        <th class="col-md-3">Tanggal</th>
                        <th class="col-md-2">jam</th>
                        <th class="col-md-2">Status</th>
                        <th class="col-md-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataEmployees as $key=> $value)
                    <tr>
                        <td><input type="checkbox" wire:key="{{ $value->id }}"" value="{{ $value->id }}" wire:model.live="employee_selected_id"></td>
                        <td>{{ $dataEmployees->firstitem() + $key }}</td>
                        <td>{{ $value->todo }}</td>
                        <td>{{ $value->tanggal }}</td>
                        <td>{{ $value->jam }}</td>
                        <td>{{ $value->status }}</td>
                        <td>
                            <a wire:click="edit({{ $value->id }})" class="btn btn-warning btn-sm">Edit</a>
                            <a wire:click="delete_confirmation({{ $value->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $dataEmployees->links() }}
        </div>
        <!-- AKHIR DATA -->
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> --}}

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Delete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Yakin akan menghapus data ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" wire:click="delete()">Ya!</button>
      </div>
    </div>
  </div>
</div>
    </div>