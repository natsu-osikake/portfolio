<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>家計簿アプリ</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <header class="text-center mb-5">
            <h1 class="display-4 fw-bold">家計簿アプリ</h1>
        </header>

        <!-- タブ -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <span class="nav-link active">収支一覧</span>
            </li>
            <li class="nav-item">
                <span class="nav-link active">CSV取り込み</span>
            </li>
        </ul>

        <!-- メッセージ -->
        @if (session('flash_message'))
            <div class="alert alert-success">
                {{ session('flash_message') }}
            </div>
        @endif
        @if (session('flash_error_message'))
            <div class="alert alert-danger">
                {{ session('flash_error_message') }}
            </div>
        @endif

        <div class="row">
            <!-- 左：収支一覧 -->
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">収支一覧</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>日付</th>
                                    <th>カテゴリ</th>
                                    <th>金額</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($homebudgets as $item)
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>
                                            <span class="{{ $item->category->name == '収入' ? 'text-success' : 'text-danger' }}">
                                                {{ $item->price }}円
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('homebudget.edit', ['id' => $item->id]) }}" method="">
                                                    <input type="submit" value="更新" class="btn btn-sm btn-warning">
                                                </form>
                                                <form action="{{ route('homebudget.destroy', ['id' => $item->id]) }}" method="POST">
                                                    @csrf
                                                    <input type="submit" value="削除" class="btn btn-sm btn-danger">
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- ページネーション -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{ $homebudgets->links() }}
                            </div>
                            <div class="text-end">
                                <p class="mb-0">収支合計：{{ $payment }}円</p>
                                <p class="mb-0">収入合計：{{ $income }}円</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 右：収支の追加 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">収支の追加</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="date" class="form-label">日付</label>
                                <input type="date" id="date" name="date" class="form-control">
                                @if ($errors->has('date'))
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">カテゴリ</label>
                                <select name="category" id="category" class="form-select">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">金額</label>
                                <input type="text" id="price" name="price" class="form-control">
                                @if ($errors->has('price'))
                                    <small class="text-danger">{{ $errors->first('price') }}</small>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success w-100">追加</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (必要に応じて) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
