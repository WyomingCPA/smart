@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Статистика</h1>
@stop

@section('content')
<div class="row">
    {{-- Очередь VK Anime --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $all_favorite_product_count ?? 0 }}</h3>
                <p>Продуктов в избранном</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <a href="" class="small-box-footer">
                Подробнее <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-8 col-8">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Статистика продуктов</h3>
            </div>

            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Исследуется</th>
                            <th>Доступно</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_category_stat as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['count_research_product'] }}</td>
                            <td>{{ $item['count_available_product'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop