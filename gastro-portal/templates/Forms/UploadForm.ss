
<form $AttributesHTML>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType"><% if $MessageType == "good" %><i data-uk-icon="check" class="uk-margin-right"></i><% end_if %>$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<div id="upload-form-container" class="upload-container member-section-container" hidden>
		<table class="uk-table uk-table-small uk-table-middle">

		<tbody id="document-file">
			
		</tbody>
		</table>
		<div id="upload-document" class="js-upload simple uk-placeholder uk-text-center" data-container="#document-file" data-field-name="ID" data-type="file">
			<div class="form-field">
				<span data-uk-icon="icon: cloud-upload"></span>
				<span class="uk-text-middle"><%t Member.ChargeFile 'Upload a file' %></span>
				<div data-uk-form-custom>
					<input type="file" name="files" />
					<span class="uk-link"><%t Member.SelectFile 'or select one' %></span>
				</div>
			</div>
			<% with Fields.FieldByName('FileID') %>
			$FieldHolder
			<% end_with %>
		</div>
		<% with Fields.FieldByName('Title') %>
		$FieldHolder
		<% end_with %>
		<% with Fields.FieldByName('Description') %>
		$FieldHolder
		<% end_with %>
		<% with Fields.FieldByName('Partners') %>
		$FieldHolder
		<% end_with %>
		<% with Fields.FieldByName('OwnerID') %>
		$FieldHolder
		<% end_with %>
		<% with Fields.FieldByName('ParentID') %>
		$FieldHolder
		<% end_with %>
		<% with Fields.FieldByName('ID') %>
		$FieldHolder
		<% end_with %>
		<% with Fields.FieldByName('SecurityID') %>
		$FieldHolder
		<% end_with %>

		<% if $Actions %>
		<div class="btn-toolbar uk-text-right">
			<button  data-uk-toggle="target: #upload-form-container" class="uk-button uk-button-default"><%t Global.Cancel 'Cancel' %></button>
			<% loop $Actions %>
			$Field
			<% end_loop %>
		</div>
		<% end_if %>
	</div>
	</form>
