<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $todo, $tanggal, $jam, $status, $employee_id, $katakunci, $employee_selected_id = [];
    public $updateData = false;
    public function store()
    {

        $rules = [
            'todo' => 'required|string|max:30',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'status' => 'required|in:belum,sedang,sudah',
        ];


        $messages = [
            'todo.required' => 'Todo wajib diisi.',
            'todo.max' => 'Todo tidak boleh lebih dari 30 karakter.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jam.required' => 'Jam wajib diisi.',
            'jam.date_format' => 'Format jam harus HH:mm (24 jam).',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus salah satu dari: belum, sedang, atau sudah.',
        ];

        // Validasi data
        $validatedData = $this->validate($rules, $messages);

        // Simpan data ke database
        ModelsEmployee::create([
            'todo' => $this->todo,
            'tanggal' => $this->tanggal,
            'jam' => $this->jam,
            'status' => $this->status,
        ]);


        // Beri pesan sukses
        session()->flash('message', 'Data berhasil dibuat.');

        // Bersihkan input setelah berhasil menyimpan
        $this->clear();
    }


    public function edit($id)
    {
        $data = ModelsEmployee::find($id);
        $this->todo = $data->todo;
        $this->tanggal = $data->tanggal;
        $this->jam = $data->jam;
        $this->jam = $data->status;

        $this->updateData = true;
        $this->employee_id = $id;
    }

    public function update()
    {
        $rules = [
            'todo' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
            'status' => 'required',
        ];
        $pesan = [
            'todo.required' => 'todo wajib diisi',
            'tanggal.required' => 'tanggal wajib diisi',
            'jam.required' => 'jam tidak valid',
            'status.required' => 'status wajib diisi',
        ];
        $validated = $this->validate($rules, $pesan);
        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validated);
        session()->flash('message', 'Data updated');

        $this->clear();
    }

    public function render()
    {
        if ($this->katakunci != null) {
            $data = ModelsEmployee::where('todo', 'like', '%' . $this->katakunci . '%')
                ->orwhere('tanggal', 'like', '%' . $this->katakunci . '%')
                ->orwhere('jam', 'like', '%' . $this->katakunci . '%')
                ->orderBy('status', 'asc')->paginate(2);
        } else {
            $data = ModelsEmployee::orderBy('todo', 'asc')->paginate(2);
        }
        return view('livewire.employee', ['dataEmployees' => $data]);
    }

    public function clear()
    {
        $this->todo = '';
        $this->tanggal = '';
        $this->jam = '';
        $this->updateData = false;
        $this->employee_id = '';
        $this->employee_selected_id = [];
    }

    public function delete_confirmation($id)
    {
        if ($id != '') {
            $this->employee_id = $id;
        }
    }

    public function delete()
    {
        if ($this->employee_id != '') {
            $id = $this->employee_id;
            ModelsEmployee::find($id)->delete();
        }

        if (count($this->employee_selected_id)) {
            for ($x = 0; $x < count($this->employee_selected_id); $x++) {
                ModelsEmployee::find($this->employee_selected_id[$x])->delete();
            }
        }
        session()->flash('message', 'Data dihapus');
        $this->clear();
    }
}
