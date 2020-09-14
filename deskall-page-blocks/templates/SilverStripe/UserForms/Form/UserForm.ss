 <div class="dk-text-content uk-width-1-1 uk-margin-small"><small class="uk-text-small"><%t Form.RequiredFieldsLabel 'Die mit einem Stern (*) markierten Felder sind Pflichtfelder.' %></small></div>

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
    </div>
<% end_if %>

<% if $Steps.Count > 1 %>
	<% include SilverStripe\\UserForms\\Form\\UserFormStepNav %>
<% else %>
	<% include UserFormActionNav %>
<% end_if %>
</form>
