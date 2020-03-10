<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<div class="uk-child-width-1-1" data-uk-grid>
		<% loop $Controller.getCompetences %>
			<div>
				<fieldset>
					<legend class="uk-text-large uk-heading-line"><strong>$Title</strong></legend>
					<div class="uk-panel uk-padding-small">
						<% if isGroup %>
							<% loop Children %>
							<div class="uk-margin">
								<div><strong>$Title</strong></div>
								<div class="uk-panel uk-padding-small">
									<% if isGroup %>
										<% loop Children %>
										<div class="uk-margin">
											<div><strong>$Title</strong></div>
											<div class="uk-panel uk-padding-small">
												<div class="uk-grid-small uk-child-width-auto" data-uk-grid>
													<% loop Values %>
													<label><input type="checkbox" class="uk-checkbox" name="{$Parent.Title}[]" value="$Title" />$Title</label>
													<% end_loop %>
												</div> 
											</div>
										</div>
										<% end_loop %>
									<% else %>
									<div class="uk-grid-small uk-child-width-auto" data-uk-grid>
										<% loop Values %>
										<label><input type="checkbox" class="uk-checkbox" name="{$Parent.Title}[]" value="$Title" />$Title</label>
										<% end_loop %>
									</div> 
									<% end_if %>
								</div>
							</div>
							<% end_loop %>
						<% else %>
						<div class="uk-child-width-auto" data-uk-grid>
							<% loop Values %>
							<label><input type="checkbox" class="uk-checkbox" name="{$Parent.Title}[]" value="$Title" />$Title</label>
							<% end_loop %>
						</div> 
						<% end_if %>
					</div>
					
				</fieldset>
			</div>
		<% end_loop %>
	</div>
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
