<!-- Add an id to the tab container for easier identification in JavaScript -->
<ul class="nav nav-tabs" id="messageTabs">
  <li class="nav-item">
    <a class="nav-link active" id="incomingTab" href="#" onclick="showMessages('incoming')">
      <i class="bi bi-arrow-down-left-circle mx-2"></i>@lang('messages.messages.recieved_msg')
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="outgoingTab" href="#" onclick="showMessages('outgoing')">
      <i class="bi bi-arrow-up-right-circle mx-2"></i>@lang('messages.messages.sent_msg')
    </a>
  </li>
</ul>

<script>
  //change tabs
  function showMessages(type) {
    // Hide both message containers initially
    document.getElementById('incomingMessages').style.display = 'none';
    document.getElementById('outgoingMessages').style.display = 'none';

    // Highlight the active tab
    document.getElementById('incomingTab').classList.remove('active');
    document.getElementById('outgoingTab').classList.remove('active');

    // Show the selected message container and highlight the active tab
    if (type === 'incoming') {
      document.getElementById('incomingMessages').style.display = 'block';
      document.getElementById('incomingTab').classList.add('active');
    } else if (type === 'outgoing') {
      document.getElementById('outgoingMessages').style.display = 'block';
      document.getElementById('outgoingTab').classList.add('active');
    }
  }
</script>
