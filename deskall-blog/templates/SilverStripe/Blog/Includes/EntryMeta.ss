<div data-uk-grid>
    <div class="uk-width-1-2@s">
        <% if $Categories.exists %>
            <% loop $Categories %>
                <a href="$Link" title="$Title">$Title</a><% if not Last %>, <% else %> | <% end_if %>
            <% end_loop %>
        <% end_if %>
         <% if $MinutesToRead < 1 %>
            <%t SilverStripe\\Blog\\Model\\Blog.LessThanAMinuteToRead "Less than a minute to read" %> | 
        <% else %>
            $MinutesToRead <%t SilverStripe\\Blog\\Model\\Blog.MinutesToRead "Minute(s) to read" %> | 
        <% end_if %>

        <%t SilverStripe\\Blog\\Model\\Blog.Posted "Posted" %>
        <a href="$MonthlyArchiveLink">$PublishDate.Nice</a>
    </div>
    <div class="uk-width-1-4@s uk-text-center">
        <% if $Comments.exists %>
            <a href="{$Link}#comments-holder" data-uk-icon="icon: comments;ratio: 2;" data-uk-scroll>
                
                $Comments.count
            </a>
        <% end_if %>
    </div>
     <div class="uk-width-1-4@s">
        <div class="uk-flex uk-flex-around">
            <div class="shariff" data-lang="de" data-url="$AbsoluteLink" data-button-style="icon" data-mail-url="mailto:" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
        </div>
    </div>
</div>