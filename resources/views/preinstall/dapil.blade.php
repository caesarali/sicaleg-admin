@extends('layouts.setup')

@section('content')
    <div id="content" class="container" style="margin: 7% auto">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header bg-white border-0 text-center">
                        Dapil Calon Legislatif
                    </h5>
                    <div class="card-body">
                        <form method="POST" action="#">
                            @csrf
                            <div class="form-row">
                                <div class="col">
                                    <select name="locationable_id" class="form-control">
                                        <option value="" hidden>Pilih dapil:</option>
                                        @foreach ($locations as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-plus mr-1"></i> Tambahkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr v-for="x in 5" :key="x">
                                    <td class="text-center" width="1%">@{{ x }}.</td>
                                    <td>Makassar</td>
                                    <td class="text-right">
                                        <a href="#" class="text-secondary ml-2">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-right">
                        <button type="button" class="btn btn-primary">Next <i class="fas fa-chevron-right ml-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    locations: @json($locations),
                    dapil: []
                }
            },
            methods: {
                add(item) {
                    this.dapil.push(item)
                }
            }
        })
    </script>
@endsection
