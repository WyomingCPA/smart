@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Смартфоны')

{{-- Content body: main page content --}}

@section('content_body')
<form id="bulk-action-form" method="POST" action="">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Посты</h3>
            <div class="mb-3">
                <button type="button" id="setLearn" class="btn btn-success btn-sm">
                    <i class="fas fa-check"></i> Повторил
                </button>

                <button type="button" id="setFavorite" class="btn btn-warning btn-sm">
                    <i class="fas fa-telegram"></i> В избранное
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        {{-- Чекбокс "Выбрать все" --}}
                        <th width="30">
                            <input type="checkbox" id="check-all">
                        </th>
                        <th>Price</th>
                        <th>Name</th>
                        <th>Count Learn</th>
                        <th>Actions</th>
                        <th>Is Favorite</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                    <tr class="toggle-row" data-target="details-{{ $product->id }}" style="cursor:pointer;">
                        <td>
                            <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="row-check">
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->count_learn }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-pen"></i> Редактировать
                            </a>
                            <a href="{{ route('products.detail', $product->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Детали
                            </a>
                        </td>
                    </tr>
                    <!-- Скрытая строка с деталями -->
                    <tr id="details-{{ $product->id }}" class="details-row" style="display:none;">
                        <td colspan="3">
                            <strong>Описание:</strong> {!! $product->description !!} <br>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Нет данных</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Пагинация --}}
        <div class="card-footer">
            {{ $products->links() }}
        </div>
    </div>
</form>
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    // Чекбокс "выбрать все"
    document.getElementById('check-all').addEventListener('change', function() {
        let checks = document.querySelectorAll('.row-check');
        checks.forEach(c => c.checked = this.checked);
    });

    function getSelectedIds() {
        let ids = [];
        document.querySelectorAll('.row-check:checked').forEach(c => {
            ids.push(c.value);
        });
        return ids;
    }

    // Универсальная отправка POST
    function sendAction(url) {
        let ids = getSelectedIds();

        if (ids.length === 0) {
            alert("Ничего не выбрано");
            return;
        }

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                ids: ids
            })
        }).then(r => location.reload());
    }
    document.getElementById('setLearn').onclick = () =>
        sendAction("{{ route('product.learn') }}");

    document.getElementById('setFavorite').onclick = () =>
        sendAction("{{ route('product.set-favorite') }}");


        
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".toggle-row").forEach(row => {
            row.addEventListener("click", function() {
                const targetId = this.dataset.target;
                const targetRow = document.getElementById(targetId);
                if (targetRow.style.display === "none") {
                    targetRow.style.display = "table-row";
                } else {
                    targetRow.style.display = "none";
                }
            });
        });
    });
</script>
@endpush