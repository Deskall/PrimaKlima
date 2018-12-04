<form $AttributesHTML>

<% include SilverStripe\\UserForms\\Form\\UserFormProgress %>
<% include SilverStripe\\UserForms\\Form\\UserFormStepErrors %>

<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
<% else %>
	<p id="{$FormName}_error" class="message $MessageType" aria-hidden="true" style="display: none;"></p>
<% end_if %>

<% if $Legend %>
    <fieldset class="uk-fieldset">
        <legend class="uk-legend">$Legend</legend>
        <% include SilverStripe\\UserForms\\Form\\UserFormFields %>
    </fieldset>
<% else %>
    <div class="userform-fields">
        <% include SilverStripe\\UserForms\\Form\\UserFormFields %>
        <!-- TO DO : make a field with template and automatic link to any form -->
        <div class="dk-text-content uk-width-1-1 uk-margin-small"><label class="acceptance"><input type="checkbox" name="acceptance" required /> Sie erklären sich damit einverstanden, dass Ihre Daten zur Bearbeitung Ihres Anliegens verwendet werden. Weitere Informationen und Widerrufshinweise finden Sie in der <a href="/unternehmen/datenschutzerklaerung" title="Datenschutzerklärung Seite" target="_blank">Datenschutzerklärung</a>. Eine Kopie Ihrer Nachricht wird an Ihre E-Mail-Adresse geschickt. </label>
        </div>
    </div>
<% end_if %>

<% if $Steps.Count > 1 %>
	<% include SilverStripe\\UserForms\\Form\\UserFormStepNav %>
<% else %>
	<% include UserFormActionNav %>
<% end_if %>
</form>
