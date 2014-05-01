<?= '<?xml version="1.0" encoding="utf-8"?>'; ?>
<feed xmlns='http://www.w3.org/2005/Atom' xmlns:openSearch='http://a9.com/-/spec/opensearchrss/1.0/'
      xmlns:blogger='http://schemas.google.com/blogger/2008' xmlns:georss='http://www.georss.org/georss'
      xmlns:gd="http://schemas.google.com/g/2005" xmlns:thr='http://purl.org/syndication/thread/1.0'>
   <id>com:easylearntutorial:feed:60a76c80b91C</id>
   <updated>2014-05-01T07:59:39.847-07:00</updated>
   <title type='text'>Easy Learn Tutorial</title>
   <subtitle type='html'></subtitle>
   <link rel='http://schemas.google.com/g/2005#feed' type='application/atom+xml'
         href='http://easylearntutorial.com/feeds'/>
   <link rel='self' type='application/atom+xml' href='http://www.easylearntutorial.com/feeds'/>
   <link rel='alternate' type='text/html' href='http://www.easylearntutorial.com/'/>
   <author>
      <name>Rodrigo Silveira</name>
      <uri>https://plus.google.com/103737161295645708507</uri>
      <email>noreply@blogger.com</email>
      <gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='32' height='32'
                src='//lh4.googleusercontent.com/-IyaR20dJBtQ/AAAAAAAAAAI/AAAAAAAALsQ/pfda68LONFg/s512-c/photo.jpg'/>
   </author>

   <?php foreach ($data['posts'] as $post): ?>
      <entry>
         <title type='text'>Nintendo Wii U Game Development</title>
         <link href="http://example.org/2003/12/13/atom03"/>
         <link rel="alternate" type="text/html" href="http://example.org/2003/12/13/atom03.html"/>
         <id>com:easylearntutorial:<?= md5($post['id']); ?></id>
         <published>2013-10-12T08:18:00.001-07:00</published>
         <updated>2003-12-13T18:30:02Z</updated>
         <summary type='html'>Some text.</summary>
         <author>
            <name>Rodrigo Silveira</name>
            <uri>https://plus.google.com/103737161295645708507</uri>
            <email>noreply@blogger.com</email>
            <gd:image rel='http://schemas.google.com/g/2005#thumbnail' width='32' height='32'
                      src='//lh4.googleusercontent.com/-IyaR20dJBtQ/AAAAAAAAAAI/AAAAAAAALsQ/pfda68LONFg/s512-c/photo.jpg'/>
         </author>
      </entry>
   <?php endforeach; ?>
</feed>
