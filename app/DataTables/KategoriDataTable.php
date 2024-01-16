<?php

namespace App\DataTables;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KategoriDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('aksi', function ($kategori) {
                return '<button onclick="editForm(`' . route('kategori.update', $kategori->id) . '`)">Edit</button>
                        <button onclick="deleteData(`' . route('kategori.destroy', $kategori->id) . '`)">Hapus</button>';
            })
            ->rawColumns(['aksi']);
    }

    public function query(Kategori $model): QueryBuilder
    {
        return $model->select(['id', 'nama_kategori', 'created_at']) // Include 'created_at' column
            ->orderBy('id', 'asc'); // Order by creation date in descending order
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('kategori-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('add'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('nama_kategori'),
            Column::make('aksi')->title('Action'),
        ];
    }

    protected function filename(): string
    {
        return 'Kategori_' . date('YmdHis');
    }
}
