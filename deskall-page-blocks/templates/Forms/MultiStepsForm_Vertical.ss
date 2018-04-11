<form $AttributesHTML>

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
        <ul uk-accordion>
        <% include SilverStripe\\UserForms\\Form\\UserFormFields %>
        </ul>
    </div>
<% end_if %>

<% if $Steps.Count > 1 %>
	<% include MultiStepsFormNav_Vertical %>
<% else %>
	<% include UserFormActionNav %>
<% end_if %>
</form>
