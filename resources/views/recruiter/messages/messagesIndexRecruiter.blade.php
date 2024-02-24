@extends('layouts.layout')

@section('navbar')
  @include('recruiter.includes.nav.navbarSignedInRecruiter')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center mt-5 mb-5">

      <div class="col-lg-6 col-12">
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <form action="{{ route('messages.send') }}" method="POST" id="messageForm">
          @csrf

          <div class="form-group">
            <h2>@lang('messages.messages.compose_message')</h2>
            <label for="receiver_id"><i class="bi bi-arrow-right-circle me-1"></i>@lang('messages.messages.to')</label>
            <select name="receiver_id" id="receiver_id" class="form-control" required>
              <option value="" disabled selected>@lang('messages.messages.select_recruiter')</option>
              @foreach ($applicants as $applicant)
                <option value="{{ $applicant->id }}">{{ $applicant->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="message"><i class="bi bi-envelope me-1"></i>@lang('messages.messages.message')</label>
            <textarea name="message" rows="10" class="form-control" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary mt-3 float-end float-lg-start float-md-start"><i
              class="bi bi-send me-1"></i>@lang('messages.messages.send_message')</button>


        </form>

      </div>

      <div class="col-lg-6 col-12 mt-sm-4">

        <h2>@lang('messages.messages.messages')</h2>
        @include('students.includes.navTabs.messageNavTabs')
        @if (session('deleteSuccess'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('deleteSuccess') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if (session('deleteError'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('deleteError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div id="incomingMessages">
          <ul class="list-group">
            @forelse ($incomingMessages as $message)
              <hr>
              <li class="list-group-item">
                <strong>@lang('messages.messages.from')</strong> {{ $message->sender->name }}
                <br>

                <strong>@lang('messages.messages.message')</strong> {{ $message->message }}
                <br>

                <div class="container d-flex justify-content-between">

                  <div class="col-5 mt-3 rounded-1 p-1 text-primary me-3">
                    <small>@lang('messages.messages.recieved')</small>
                    <small id="timestamp-{{ $message->id }}"></small>
                  </div>

                  <div class="col-7">
                    <div class="container d-flex justify-content-end">

                      <div class="row me-3">
                        <button type="button" class="btn btn-primary text-white mt-2"
                          onclick="fillForm({{ $message->sender_id }})">
                          <i class="bi bi-reply me-1"></i>
                          @lang('messages.messages.reply')
                        </button>
                      </div>

                      <div class="row">
                        @if ($message->sender && $message->sender->hasCv())
                          <a href="{{ route('viewCv', $message->sender->cv->id) }}" target="_blank">
                            <button type="button" class="btn btn-success text-white  mt-2">
                              <i class="bi bi-file-earmark-person"></i>
                              @lang('messages.recruiter_view_applicants.view_CV')
                            </button>
                          </a>
                        @endif
                      </div>

                      <div class="row ms-1">
                        <x-form-button :action="route('messages.destroy', ['id' => $message->id])" method="DELETE" class="btn btn-danger text-white mt-2 ">
                          <span><i class="bi bi-trash me-1"></i>@lang('messages.messages.delete')</span>
                        </x-form-button>
                      </div>
                    </div>
                  </div>

                </div>
              </li>

            @empty
              <li class="list-group-item">@lang('messages.messages.no_messages')</li>
            @endforelse
          </ul>

          <div class="container d-flex justify-content-center mt-2">
            {{ $incomingMessages->links() }}
          </div>
        </div>

        <div id="outgoingMessages" style="display: none; overflow-y: auto; max-height: 600px;">
          <div class="d-flex flex-column">
            @forelse ($outgoingMessages as $message)
              <div class="col mb-2 mt-1">
                <div class="card ">
                  <div class="card-header">
                    <strong>@lang('messages.messages.to')</strong> {{ $message->receiver->name }}
                  </div>
                  <div class="card-body">
                    <p class="card-text"><strong>@lang('messages.messages.message')</strong> {{ $message->message }}
                    </p>
                  </div>
                  <div class="card-footer d-flex justify-content-between">
                    <div class="container d-flex align-items-center">
                      <small class="me-1">@lang('messages.messages.sent')</small>
                      <small id="timestamp-{{ $message->id }}"></small>
                    </div>
                    <div class="container">
                      <button type="button" class="btn btn-primary text-white mt-2 float-end"
                        onclick="fillForm({{ $message->receiver_id }})">
                        <i class="bi bi-reply me-1"></i>
                        @lang('messages.messages.compose_message')
                      </button>
                    </div>
                  </div>

                </div>
              </div>
            @empty
              <div class="col">
                <div class="card">
                  <div class="card-body">
                    <p class="card-text">@lang('messages.messages.no_messages')</p>
                  </div>
                </div>
              </div>
            @endforelse
          </div>
        </div>




      </div>
    </div>
  </div>
@endsection


@section('footer')
  @include('includes.footer')
@endsection

@section('specialJS')
  <script>
    //manual timestamps and notifications
    function formatTimestamp(timestamp) {
      const now = new Date();
      const messageDate = new Date(timestamp);
      const timeDiff = now - messageDate;

      const monthNames = [
        "@lang('messages.month.january')",
        "@lang('messages.month.february')",
        "@lang('messages.month.march')",
        "@lang('messages.month.april')",
        "@lang('messages.month.may')",
        "@lang('messages.month.june')",
        "@lang('messages.month.july')",
        "@lang('messages.month.august')",
        "@lang('messages.month.september')",
        "@lang('messages.month.october')",
        "@lang('messages.month.november')",
        "@lang('messages.month.december')",
      ];

      //get the translated months and find the given month
      const monthIndex = messageDate.getMonth();
      const monthName = monthNames[monthIndex];
      //get rid of pm 
      const options = {
        hour12: false
      };
      const formattedTime = messageDate.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
        ...options
      });

      // convert milliseconds to minutes
      const minutes = Math.floor(timeDiff / 60000);

      if (minutes < 1) {
        return "@lang('messages.timestamp.just_now')";
      } else if (minutes < 60) {
        const minuteString = minutes === 1 ? "@lang('messages.timestamp.minute')" : "@lang('messages.timestamp.minutes')";
        return `${minutes} ${minuteString} @lang('messages.timestamp.ago')`;
      } else if (messageDate.toDateString() === now.toDateString()) {
        // If the message is from today, format as "Today at HH:mm"
        return `@lang('messages.timestamp.today_at') ${formattedTime}`;
      } else if (messageDate.toDateString() === new Date(now - 86400000).toDateString()) {
        // If the message is from yesterday, format as "Yesterday at HH:mm"
        return `@lang('messages.timestamp.yesterday_at') ${formattedTime}`;
      } else {
        // For older messages, format as "Month Day at HH:mm"
        return `@lang('messages.timestamp.month_day_at') ${messageDate.getDate()} ${monthName} ${formattedTime}`;
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      @php
        $incomingMessagesData = $incomingMessages->toArray();
        $outgoingMessagesData = $outgoingMessages->toArray();
      @endphp

      const incomingMessages = @json($incomingMessagesData['data']);

      const outgoingMessages = @json($outgoingMessagesData);

      function formatMessagesTimestamp(messages) {
        if (Array.isArray(messages)) {
          messages.forEach(function(message) {
            const timestampElement = document.getElementById(`timestamp-${message.id}`);
            if (timestampElement) {
              const formattedTimestamp = formatTimestamp(message.created_at);
              timestampElement.innerText = formattedTimestamp;
            }
          });
        } else {
          console.error('Invalid or non-array messages data:', messages);
        }
      }

      // Call the function for both incoming and outgoing messages
      formatMessagesTimestamp(incomingMessages);
      formatMessagesTimestamp(outgoingMessages);
    });

    //get the sender_id and make it the receiver_id to send a message with the reply btn
    function fillForm(senderId) {
      // Set the sender_id in the form
      document.getElementById('receiver_id').value = senderId;
    }
  </script>
@endsection
