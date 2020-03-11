<ul>
<% loop $Controller.getAssignedCompetences %>
<li>$Title: $Value</li>
<% end_loop %>
</ul>
<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<ul data-uk-accordion>
		<% loop $Controller.getCompetences %>
		<li <% if First %>class="uk-open"<% end_if %>>
		    <a class="uk-accordion-title"><strong class="uk-text-large">$Title</strong></a>
		    <div class="uk-accordion-content">
		    	<div class="uk-panel uk-padding-small">
		    		<% if isGroup %>
		    			<% loop Children %>
		    			<div class="uk-margin">
		    				<div><strong>$Title</strong></div>
		    				<div class="uk-panel uk-padding-small">
		    					<% if isGroup %>
		    						<% loop Children %>
		    						<div class="uk-margin">
		    							<% if FieldType == "range" %>
		    							<div class="uk-grid-small" data-uk-grid>
		    								<div class="uk-width-auto@m">$Title</div>
		    								<div class="uk-width-expand"><input type="range" name="ProfilParameters[$Title]" class="uk-range" value="3" min="$Min" max="$Max" step="1" /></div>
		    							</div>
		    							<% else %>
		    							<div><strong>$Title</strong></div>
		    							<div class="uk-panel uk-padding-small">
		    								<div class="uk-grid-small uk-child-width-auto" data-uk-grid>
		    									<% loop Values %>
		    									<label><input type="checkbox" class="uk-checkbox" name="ProfilParameters[{$Parameter.Parent.Title}][]" value="$Title" checked="$Top.Controller.hasCompetence($Parameter.Parent.Title,$Title,1)" />$Title</label>
		    									<% end_loop %>
		    								</div> 
		    							</div>
		    							<% end_if %>
		    						</div>
		    						<% end_loop %>
		    					<% else %>
		    					<div class="uk-grid-small uk-child-width-auto" data-uk-grid>
		    						<% loop Values %>
		    						<label><input type="checkbox" class="uk-checkbox" name="ProfilParameters[{$Parameter.Parent.Title}][]" value="$Title" checked="$Top.Controller.hasCompetence($Parameter.Parent.Title,$Title,1)" />$Title</label>
		    						<% end_loop %>
		    					</div> 
		    					<% end_if %>
		    				</div>
		    			</div>
		    			<% end_loop %>
		    		<% else %>
		    		<div class="uk-child-width-auto uk-grid-small" data-uk-grid>
		    			<% if groupValuesAZ %>
		    				<% loop GroupedValues.groupedBy(FirstLetter) %>
		    				<div class="uk-width-1-1"><strong>$FirstLetter</strong></div>
		    				<div>
		    					<div class="uk-child-width-auto uk-grid-small" data-uk-grid>
		    						<% loop Children %>
		    						<label><input type="checkbox" class="uk-checkbox" name="ProfilParameters[{$Parameter.Title}][]" value="$Title" checked="$Top.Controller.hasCompetence($Parameter.Title,$Title,1)" />$Title</label>
		    						<% end_loop %>
		    					</div>
		    				</div>
		    				<% end_loop %>
		    			<% else %>
		    				<% loop Values %>
		    				<label><input type="checkbox" class="uk-checkbox" name="ProfilParameters[{$Parameter.Parent.Title}][]" value="$Title" checked="$Top.Controller.hasCompetence($Parameter.Parent.Title,$Title,1)" />$Title</label>
		    				<% end_loop %>
		    			<% end_if %>
		    		</div> 
		    		<% end_if %>
		    	</div>
		    </div>
		</li>
		<% end_loop %>
	</ul>
	<% with Fields.FieldByName('SecurityID') %>
	$FieldHolder
	<% end_with %>
	<% if $Actions %>
	<div class="btn-toolbar">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
	<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
