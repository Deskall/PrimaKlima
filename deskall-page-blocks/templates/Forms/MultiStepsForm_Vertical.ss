<form $AttributesHTML data-uk-accordion>

<% include SilverStripe\\UserForms\\Form\\UserFormStepErrors %>

<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
<% else %>
	<p id="{$FormName}_error" class="message $MessageType" aria-hidden="true" style="display: none;"></p>
<% end_if %>

<% if $Legend %>
    <fieldset class="uk-fieldset">
        <legend class="uk-legend uk-accordion-title">$Legend</legend>
        <div class="uk-accordion-content">
            <% include SilverStripe\\UserForms\\Form\\UserFormFields %>
        </div>
    </fieldset>
<% else %>
    <div class="userform-fields uk-accordion-content">
        <% include SilverStripe\\UserForms\\Form\\UserFormFields %>
    </div>
<% end_if %>

<% if $Steps.Count > 1 %>
	<% include SilverStripe\\UserForms\\Form\\UserFormStepNav %>
<% else %>
	<% include UserFormActionNav %>
<% end_if %>
</form>
