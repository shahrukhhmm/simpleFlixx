@extends('admin.layout.app')

@section('content')
    {{-- <div class="content-body"> --}}
        <div class="container-fluid">
            <div class="row">

                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Chat</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    {{-- <div class="card"> --}}
                        <div class="card-header">
                            <h4 class="card-title">Chat Box</h4>
                        </div>
                        <div class="card-body">
                            <div class="flex " style="height: 600px;">
                                <!-- Users Sidebar -->
                                <div class="w-1/4 bg-white shadow-lg p-4 rounded-lg h-full">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Online Users</h3>
                                    <ul id="user-list" class="space-y-2">
                                        @foreach ($users as $user)
                                            <li class="cursor-pointer p-2 bg-gray-200 rounded hover:bg-gray-300 transition"
                                                data-id="{{ $user->id }}"
                                                onclick="selectUser({{ $user->id }}, '{{ $user->name }}')">
                                                {{ $user->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Chat Area -->
                                <div class="w-3/4 px-2">
                                    <div class="bg-white shadow-lg rounded-lg h-full flex flex-col">
                                        <div class="p-4 border-b">
                                            <h2 id="chat-title" class="text-xl font-semibold text-gray-800">Select a user to start chatting</h2>
                                        </div>
                                        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-gray-50">
                                            <!-- Messages will be loaded here -->
                                        </div>
                                        <div class="p-4 border-t">
                                            <div class="flex space-x-2">
                                                <input type="text" id="chat-input" class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="Type a message..." disabled>
                                                <button id="send-message" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                                                        disabled>Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    {{-- </div> --}}
@endsection

@push('scripts')
    <script>
        let currentUserId = null;

        function selectUser(userId, userName) {
            currentUserId = userId;
            $('#chat-title').text(`Chat with ${userName}`);
            $('#chat-input').prop('disabled', false);
            $('#send-message').prop('disabled', false);
            loadMessages(userId);
            $('#user-list li').removeClass('bg-gray-300').addClass('bg-gray-200');
            $(`#user-list li[data-id="${userId}"]`).removeClass('bg-gray-200').addClass('bg-gray-300');
        }

        function loadMessages(userId) {
            $.ajax({
                url: `{{ route('chat.messages', ['receiverId' => ':id']) }}`.replace(':id', userId),
                method: 'GET',
                success: function(response) {
                    $('#chat-messages').empty();
                    response.messages.forEach(msg => {
                        const isSent = msg.sender_id === {{ Auth::id() }};
                        $('#chat-messages').append(`
                            <div class="mb-2 ${isSent ? 'text-right' : 'text-left'}">
                                <p class="inline-block p-2 rounded-lg ${isSent ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'}">
                                    ${msg.message}
                                </p>
                                <span class="text-xs text-gray-500">${new Date(msg.created_at).toLocaleTimeString()}</span>
                            </div>
                        `);
                    });
                    $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
                },
                error: function(xhr, status, error) {
                    alert('Error loading messages: ' + error);
                }
            });
        }

        $('#send-message').on('click', function() {
            const message = $('#chat-input').val().trim();
            if (message && currentUserId) {
                $.ajax({
                    url: '{{ route('chat.send') }}',
                    method: 'POST',
                    data: { message: message, receiver_id: currentUserId, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        $('#chat-input').val('');
                        loadMessages(currentUserId);
                    },
                    error: function(xhr, status, error) {
                        alert('Error sending message: ' + error);
                    }
                });
            }
        });

        $('#chat-input').on('keypress', function(e) {
            if (e.which === 13 && !e.shiftKey) {
                $('#send-message').click();
                e.preventDefault();
            }
        });

        // Auto-refresh messages every 5 seconds
        setInterval(() => {
            if (currentUserId) loadMessages(currentUserId);
        }, 5000);
    </script>
@endpush

@push('styles')
    <style>
        .form-control {
            @apply border-gray-300 rounded-md p-2 w-full;
        }
        .btn {
            @apply px-4 py-2 rounded-md font-semibold;
        }
        .btn-primary {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }
        .btn-secondary {
            @apply bg-gray-500 text-white hover:bg-gray-600;
        }
        .btn-info {
            @apply bg-blue-500 text-white hover:bg-blue-600;
        }
        .btn-light {
            @apply bg-white text-pink-600 border border-pink-600 hover:bg-pink-50;
        }
        .alert {
            @apply bg-yellow-100 border border-yellow-400 text-yellow-700 p-4 rounded-md;
        }
        .chat-section {
            @apply border-t pt-4;
        }
        #chat-container {
            @apply mb-2;
        }
    </style>
@endpush
