<form>
  @csrf
    <div class="form-group">
      <label for="recipient-name" class="control-label">Recipient:</label>
      <input type="text" name="name" class="form-control form-control-border" id="recipient-name">
    </div>
    <div class="form-group">
      <label for="message-text" class="control-label">Message:</label>
      <textarea class="form-control form-control-border" name="text" id="message-text"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send message</button>
</form>