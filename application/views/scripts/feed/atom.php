<?= '<?xml version="1.0" encoding="utf-8"?>'; ?>

<feed xmlns="http://www.w3.org/2005/Atom">
   <id>com:easylearntutorial:feed:60a76c80b91C</id>
   <updated><?= date('Y-m-d H:i:s', time()); ?></updated>
   <title type='text'>Easy Learn Tutorial</title>
   <subtitle type='html'>Programming and Software Development Tutorials</subtitle>
   <link rel='self' type='application/atom+xml' href='http://www.easylearntutorial.com/feeds'/>
   <link rel='alternate' type='text/html' href='http://www.easylearntutorial.com/'/>
   <author>
      <name>Rodrigo Silveira</name>
      <uri>https://plus.google.com/103737161295645708507</uri>
      <email>noreply@blogger.com</email>
   </author>

   <?php foreach ($data['posts'] as $post): ?>
      <entry>
         <title type='text'><?= str_replace(array('&'), '', $post['title']); ?></title>
         <link href="<?= $post['url']; ?>"/>
         <id>com:easylearntutorial:<?= md5($post['url']); ?></id>
         <updated><?= date('Y-m-d H:i:s', strtotime('-' . rand(1, 5) . ' days')); ?></updated>
         <content type="html">
            <![CDATA[
            <img src="<?= $post['img']; ?>"/>
            <p><?= substr($post['description'], 0, 500); ?>...</p>
            ]]>
         </content>
         <author>
            <name>Rodrigo Silveira</name>
            <uri>https://plus.google.com/103737161295645708507</uri>
            <email>noreply@blogger.com</email>
         </author>
      </entry>
   <?php endforeach; ?>
</feed>
