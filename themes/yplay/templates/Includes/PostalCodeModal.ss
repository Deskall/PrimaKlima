<div id="modal-postal-code" data-uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" data-uk-close></button>
      
        <div class="uk-modal-body">
            <h2 class="uk-modal-title">$PLZModalTitle Das perfekte in Ihrer Region</h2>
            $PLZModalBody
            <p>Durch die Eingabe Ihrer Postleitzahl ermöglichen Sie uns die in Ihrer Region verfügbaren Produkte anzuzeigen.</p>
            <form method="POST" action="{$Link}plz-speichern">
                <div class="uk-margin">
                    <div class="uk-text-large">
                        <input class="uk-input uk-text-center" type="text" name="plz-choice" required="required" placeholder="Ihrer PLZ">
                    </div>
                </div>
                <div class="uk-flex uk-flex-center uk-flex-right@s uk-flex-wrap uk-flex-middle">
                    <a class="uk-flex-first@s uk-modal-close uk-margin-small-right">Später eingeben.</a>
                    <button class="uk-button uk-button-primary uk-flex-first" type="submit">Region wählen</button>
                </div>
            </form>
        </div>
    </div>
</div>