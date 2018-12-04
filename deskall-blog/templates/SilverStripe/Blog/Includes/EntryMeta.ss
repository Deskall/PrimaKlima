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
            <a rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u={$AbsoluteLink.URLATT}" title='<%t SilverStripe\\Blog\\Model\\Blog.ShareOn "Teilen" %> Facebook' target="_blank"><i data-uk-icon="icon: facebook;ratio:2;"></i></a>
            <a rel="nofollow" href="https://twitter.com/intent/tweet/?text={$Title.URLATT}&url={$AbsoluteLink.URLATT}&via=fitnessstriver" title='<%t SilverStripe\\Blog\\Model\\Blog.ShareOn "Teilen" %> Twitter' target="_blank"><i data-uk-icon="icon: twitter;ratio:2;"></i></a>
            <%-- <a rel="nofollow" href="#" title='<%t SilverStripe\\Blog\\Model\\Blog.ShareOn "Partager sur" %> Linkedin' target="_blank"><i data-uk-icon="icon: linkedin;ratio:2;"></i></a> --%>
    </div>
    </div>
</div>