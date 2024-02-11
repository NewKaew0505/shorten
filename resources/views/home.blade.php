@extends('layouts.app')
@section('content')
    <style>
        .popup {
            display: none;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .popup form {
            display: flex;
            flex-direction: column;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-end">
                    <button id="create" type="button" class="btn btn-primary">
                        Create new
                    </button>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">Links</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($shortages as $item)
                            <li class="list-group-item">
                                <div class="container px-4">
                                    <div class="row gx-5">
                                        <div class="col">
                                            <div class="p-3">
                                                <h4>{{ $item->title }}</h4>
                                                <a href="{{ $item->domain }}{{ $item->backhalf }}"
                                                    target="_blank">{{ $item->domain }}{{ $item->backhalf }}</a><br>
                                                <a href="{{ $item->destination }}"
                                                    target="_blank">{{ $item->destination }}</a><br>
                                                {{ $item->updated_at->format('d/m/Y') }} by {{ $item->user->username }}
                                            </div>
                                        </div>
                                        <div class="col text-end">
                                            <div class="p-3">
                                                <button onclick="copyText('{{ $item->domain }}{{ $item->backhalf }}')"
                                                    id="copyButton">Copy Text</button>
                                                <button onclick="edit({{ $item }})" id="editButton">Edit</button>
                                                <form method="POST" action="{{ route('delete') }}">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="popup_store" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup_store()">&times;</span>
            <h2 id="text-header_store">Create new</h2>
            <form method="POST" action="{{ route('store') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <label for="destination">Destination:</label>
                <input type="text" id="destination_store" name="destination" required>
                <label for="title">Title (optional):</label>
                <input type="text" id="title_store" name="title" required>
                <label for="domain">Domain:</label>
                <input type="text" id="domain_store" name="domain" value="{{ env('DOMAIN') }}" readonly required>
                <label for="backhalf">Custom back-half:</label>
                <input type="text" id="backhalf_store" name="backhalf" required>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div id="popup_edit" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup_edit()">&times;</span>
            <h2 id="text-header_edit">Edit Link</h2>
            <form id="form_update" method="post" action="{{ route('update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" id="shortage_update" name="shortage">
                <label for="destination">Destination:</label>
                <input type="text" id="destination_update" name="destination" readonly required>
                <label for="title">Title (optional):</label>
                <input type="text" id="title_update" name="title" required>
                <label for="domain">Domain:</label>
                <input type="text" id="domain_update" name="domain" value="{{ env('DOMAIN') }}" readonly required>
                <label for="backhalf">Custom back-half:</label>
                <input type="text" id="backhalf_update" name="backhalf" required>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("create").addEventListener("click", function() {
            document.getElementById("popup_store").style.display = "block";
        });

        function closePopup_store() {
            document.getElementById("popup_store").style.display = "none";
        }

        function closePopup_edit() {
            document.getElementById("popup_edit").style.display = "none";
        }

        function copyText(text) {
            var copyText = document.createElement("textarea");
            copyText.value = text;
            document.body.appendChild(copyText);
            copyText.select();
            document.execCommand("copy");
            document.body.removeChild(copyText);
        }

        function edit(item) {
            var form = document.getElementById("form_update");
            document.getElementById("shortage_update").value = item['id'];
            document.getElementById("destination_update").value = item['destination'];
            document.getElementById("title_update").value = item['title'];
            document.getElementById("backhalf_update").value = item['backhalf'];
            document.getElementById("popup_edit").style.display = "block";
        }
    </script>
@endsection
