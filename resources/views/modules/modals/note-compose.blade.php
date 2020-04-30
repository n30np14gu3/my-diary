<div class="ui small modal" id="modal-compose-form">
    <i class="close icon"></i>
    <div class="header">
        Compose your note
    </div>
    <div class="content">
        <form id="compose-form" class="ui form">
            {{csrf_field()}}
            <div class="field">
                <label>Title:</label>
                <input type="text" maxlength="100" name="title" required>
            </div>
            <div class="field">
                <label>Note (markdown support!):</label>
                <textarea name="body" required></textarea>
            </div>
            <div class="field">
                <button type="submit" class="ui fluid primary button">Compose</button>
            </div>
        </form>
    </div>
</div>
