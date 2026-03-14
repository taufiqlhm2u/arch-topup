<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class ReportTable extends PowerGridComponent
{
    public string $tableName = 'reportTable';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Order::query()
        ->with(['package.game'])
        ->where('status', 'successful')
        ->latest();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()

            ->add('id')

            ->add('no_kw')

            ->add('game', fn ($order) => $order->package->game->name)

            ->add('package', fn ($order) => $order->package->type)

            ->add('player', function ($order) {
                return $order->server_id
                    ? $order->player_id . ' (' . $order->server_id . ')'
                    : $order->player_id;
            })

            ->add('email')

            ->add('qty')

            ->add('amount', fn ($order) =>
                'Rp ' . number_format($order->amount, 0, ',', '.')
            )

            ->add('status')

            ->add('status_color', fn ($order) =>
                '<span class="px-2 py-1 text-xs rounded bg-gray-200">'
                . $order->status .
                '</span>'
            );
    }

    public function columns(): array
    {
        return [

            Column::make('No', 'id')
                ->sortable(),

            Column::make('No Order', 'no_kw')
                ->searchable(),

            Column::make('Game', 'game')
                ->searchable(),

            Column::make('Paket', 'package')
                ->sortable(),

            Column::make('Player ID', 'player')
                ->sortable(),

            Column::make('Email', 'email')
                ->searchable(),

            Column::make('Jumlah', 'qty')
                ->sortable(),

            Column::make('Bayar', 'amount')
                ->sortable(),

            Column::make('Status', 'status_badge')
                ->sortable()
                ->bodyAttribute('class', 'text-center'),

        ];
    }

    public function filters(): array
    {
        return [

            Filter::inputText('email'),

            Filter::inputText('no_kw'),

            Filter::select('status', 'status')
                ->dataSource([
                    ['id' => 'pending', 'name' => 'Pending'],
                    ['id' => 'success', 'name' => 'Success'],
                    ['id' => 'failed', 'name' => 'Failed'],
                ])
                ->optionValue('id')
                ->optionLabel('name'),
        ];
    }

}