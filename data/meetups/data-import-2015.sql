START TRANSACTION;

INSERT INTO location (id, name, address, url) VALUES
  ('fae3b251-0833-48dd-87f7-363ba1269517', 'Oasis Conference Centre', 'Arundel Street, PO1 1NH', 'http://www.oasisthevenue.co.uk/conference-centre/')
ON CONFLICT DO NOTHING;

INSERT INTO speaker (id, full_name, twitterhandle) VALUES
  ('945f1186-2541-4db3-90d3-e6fcf573c0ee', 'Adam Nagy', 'AdamTheNagy'),
  ('875011ec-f6de-4f99-a5e4-7a08784a5c61', 'Owen Beresford', 'ChannelOwen'),
  ('7d7ea477-b7c7-4ceb-86ed-fd179620bbaa', 'Chris Hoult', 'choult'),
  ('2644f2d8-9ec4-46c1-9d7b-549c7f75c84e', 'Derick Rethans', 'derickr'),
  ('5e93e3a3-358d-469a-ba11-7c9f8c8b8f93', 'Marco Pivetta', 'ocramius'),
  ('05f5cf7e-3390-400e-bf9c-a3aa009a9408', 'Mark Baker', 'Mark_Baker'),
  ('280968a8-5b04-467f-9fdf-4e5a2b9107fb', 'Ellie Zheleva', 'elizheleva'),
  ('e69c8202-66f2-4c0a-8843-f2babb7857da', 'Steve Winter', 'SteveWinterNZ'),
  ('b05b23cb-e7e3-439f-94fa-afbd8ca0a2a0', 'Rob Allen', 'akrabat'),
  ('296106e1-24c1-447f-8b6b-a3f15ebc9a6f', 'Katy Anton', 'KatyAnton'),
  ('8b66e801-bb3d-44ef-af81-4c3932563c4a', 'Jackson Willis', 'jacksonwillis'),
  ('fc2ea51f-0dce-4d58-8426-2a2edfaaca6f', 'Phil Bennett', 'phil_bennett'),
  ('6f4b9d95-8b53-403e-808a-67943ca21869', 'Mathew Weier O''Phinney', 'mwop')
ON CONFLICT DO NOTHING;

INSERT INTO meetup (id, location_id, from_date, to_date, topic) VALUES
  ('b148f550-02de-4b84-b7b3-989563a2a84b', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-01-14 19:00', '2015-01-14 23:00', null),
  ('04dccd1e-ebb9-41a0-8b88-af3fb282d620', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-02-11 19:00', '2015-02-11 23:00', null),
  ('b1295966-6598-48c2-b5f3-0654190be040', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-03-11 19:00', '2015-03-11 23:00', null),
  ('39d746e1-ff6f-4b5d-a499-dc384189189e', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-04-08 19:00', '2015-04-08 23:00', null),
  ('c7e17ba4-0328-45bf-8297-889abb72fce0', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-05-13 19:00', '2015-05-13 23:00', null),
  ('e6d323d5-d628-487e-b312-75ab02bd7b5d', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-06-10 19:00', '2015-06-10 23:00', null),
  ('dadf91a1-5b6d-49ab-9a24-f93f2ea890e7', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-07-08 19:00', '2015-07-08 23:00', null),
  ('d3426399-80c9-4fed-9cda-62f9c00fa3d1', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-08-12 19:00', '2015-08-12 23:00', null),
  ('99f96738-7187-493c-9cc4-a78a2b1cb3c9', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-09-09 19:00', '2015-09-09 23:00', null),
  ('d0ff76c4-53b7-4a40-ac2b-63458bec5f71', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-10-14 19:00', '2015-10-14 23:00', null),
  ('55855550-4ae3-4f9a-8ecd-e9a6a3722316', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-11-11 19:00', '2015-11-11 23:00', null),
  ('ec2fdaa0-38d1-4553-bba1-a9d7c241272f', 'fae3b251-0833-48dd-87f7-363ba1269517', '2015-12-09 19:00', '2015-12-09 23:00', null)
;

INSERT INTO eventbrite_data (id, meetup_id, url, eventbriteid) VALUES
  ('8a4168d7-4dda-47db-a6b0-e81630e032aa', 'b148f550-02de-4b84-b7b3-989563a2a84b', 'https://www.eventbrite.co.uk/event/15030194717', '15030194717'),
  ('c2fa0255-0393-42d1-845a-2e564c02c23a', '04dccd1e-ebb9-41a0-8b88-af3fb282d620', 'https://www.eventbrite.co.uk/event/15348702382', '15348702382'),
  ('f7633190-25e5-4aa0-8290-1a05306f8ff2', 'b1295966-6598-48c2-b5f3-0654190be040', 'https://www.eventbrite.co.uk/event/15726854445', '15726854445'),
  ('616f73a4-1a81-4ac8-90b1-a49bf415dd8a', '39d746e1-ff6f-4b5d-a499-dc384189189e', 'https://www.eventbrite.co.uk/event/16185008797', '16185008797'),
  ('8afd55e1-e5c0-4ed3-9ccf-0b54b50ca006', 'c7e17ba4-0328-45bf-8297-889abb72fce0', 'https://www.eventbrite.co.uk/event/16512822296', '16512822296'),
  ('cd329a39-b937-4e3a-9c3a-5c3e5b8d1861', 'e6d323d5-d628-487e-b312-75ab02bd7b5d', 'https://www.eventbrite.co.uk/event/16782811842', '16782811842'),
  ('69607374-e2d4-43b3-ba6d-947736e6ae57', 'dadf91a1-5b6d-49ab-9a24-f93f2ea890e7', 'https://www.eventbrite.co.uk/event/16782990376', '16782990376'),
  ('f01ca844-f2d9-45bb-975e-3e2f0bf311a3', 'd3426399-80c9-4fed-9cda-62f9c00fa3d1', 'https://www.eventbrite.co.uk/event/16783094688', '16783094688'),
  ('28ec8992-0f33-4ce6-92b0-60f7818a7627', '99f96738-7187-493c-9cc4-a78a2b1cb3c9', 'https://www.eventbrite.co.uk/event/16783273222', '16783273222'),
  ('7e7c59f4-ada4-4653-b0d5-1e34788b6269', 'd0ff76c4-53b7-4a40-ac2b-63458bec5f71', 'https://www.eventbrite.co.uk/event/16783278237', '16783278237'),
  ('d20c71ea-275e-4564-98c7-6ac77d9d45cb', '55855550-4ae3-4f9a-8ecd-e9a6a3722316', 'https://www.eventbrite.co.uk/event/16783286261', '16783286261'),
  ('a04c3870-4a2e-4e2f-bbe9-669a07864ecb', 'ec2fdaa0-38d1-4553-bba1-a9d7c241272f', 'https://www.eventbrite.co.uk/event/16783320363', '16783320363')
;

INSERT INTO talk(id, meetup_id, speaker_id, time, title, abstract) VALUES
  ('a5622914-a3e5-41f7-847b-b8ba850f9cf8', 'b148f550-02de-4b84-b7b3-989563a2a84b', '945f1186-2541-4db3-90d3-e6fcf573c0ee', '2015-01-14 19:30', '', 'Imagine if you could easily reuse any 3D design content to create immersive 3D experiences for web users. This is what the Autodesk View and Data API enables you to do. You can use it to convert 3D data designed or captured in various design softwares into a lightweight format that can be streamed into a WebGL based viewer. Not only will it have 3D geometry information but all the associated meta data as well that was captured in the design: part numbers, hierarchy, notes, etc. For more information visit: <a href="http://developer.autodesk.com" >developer.autodesk.com</a>'),
  ('c71a5feb-2922-4147-a3b2-e0814b0c628b', 'b148f550-02de-4b84-b7b3-989563a2a84b', null, '2015-01-14 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('65253a98-8797-4d59-9fe4-113f12670075', '04dccd1e-ebb9-41a0-8b88-af3fb282d620', '875011ec-f6de-4f99-a5e4-7a08784a5c61', '2015-02-11 19:30', 'Test Strategies &amp;&amp; Process', 'A summary of successful testing for business platforms mostly built with PHP.  The return on investment for testing  Many of these are network services, and all require high levels of uptime.  The practices of TDD and BDD are discussed; and realistic scenarios walked through.  I will branch out into related areas such as CI depending on time used.  Material covered should be standard practice for professional developers.'),
  ('1c4f0d22-6cee-4160-8c9a-d281e7077b65', '04dccd1e-ebb9-41a0-8b88-af3fb282d620', null, '2015-02-11 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('34e1a923-d657-4ad5-9a15-ffee4b7117a9', '04dccd1e-ebb9-41a0-8b88-af3fb282d620', null, '2015-02-11 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('ccbf8601-dfe9-45b9-8bd3-6a897d611acb', 'b1295966-6598-48c2-b5f3-0654190be040', '7d7ea477-b7c7-4ceb-86ed-fd179620bbaa', '2015-03-11 19:30', 'Your API is a UI', 'Whether you''re creating a complex web application or a simple library, everything you create has a user. Why, then, do we concentrate on our users when developing a user interface, but so often forget them when developing APIs?'),
  ('747650e5-3b85-4fda-8991-2d90ce82b080', 'b1295966-6598-48c2-b5f3-0654190be040', null, '2015-03-11 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('84521ced-cdc2-4978-b314-7e9538344c16', 'b1295966-6598-48c2-b5f3-0654190be040', null, '2015-03-11 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('a7e8b90b-1852-4e2c-9a95-3a9248e306a4', '39d746e1-ff6f-4b5d-a499-dc384189189e', '2644f2d8-9ec4-46c1-9d7b-549c7f75c84e', '2015-04-08 19:30', 'Debugging: past, present and future', 'In this talk I will go over all the past, present and future debugging techniques. The talk start by giving an overview on PHP''s (ancient) standard features for debugging, additional (userland) libraries and functionality in frameworks. After the introductions we move on to the meatier stuff and I will talk about live-action debuggers, such as Xdebug and Zend''s debugger. They both provide information while a script is being executed, in combination with IDEs. In the future, there is PHP 5.6''s phpdbg which allows for some debugging and other analysis. I am also unveiling a project that allows you to "step back" while debugging as well; introspect what your script''s or application''s exact execution paths was; and trace variable modifications.'),
  ('779d6ca5-63ef-4380-8828-bf50ad8cc207', '39d746e1-ff6f-4b5d-a499-dc384189189e', null, '2015-04-08 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('372fd90c-389f-4576-9b99-1a374addd382', '39d746e1-ff6f-4b5d-a499-dc384189189e', null, '2015-04-08 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('6fa2816a-0945-49e8-a61e-23130e9890d4', 'c7e17ba4-0328-45bf-8297-889abb72fce0', '5e93e3a3-358d-469a-ba11-7c9f8c8b8f93', '2015-05-13 19:30', 'Voodoo PHP', 'We''ve often seen "magic" code, but how does it even work? Let''s explore some arguably bad PHP coding techniques that are actually used in real world libraries to solve problems that would otherwise be a huge burden for all of us. Do not try this at home!'),
  ('c3cceddd-44ef-46a4-bd46-d16b60b94e90', 'c7e17ba4-0328-45bf-8297-889abb72fce0', null, '2015-05-13 20:30', 'Giveaway - 1x copy of Grumpy Little Book of Hack by Chris Hartjes', null),
  ('3b974bc9-6e2e-435a-b413-5444d1f898ee', 'c7e17ba4-0328-45bf-8297-889abb72fce0', null, '2015-05-13 20:30', 'Giveaway - FREE Ticket for PHP South Coast conference 2015!!!', null),
  ('d58bc67b-074b-4132-b09b-2ca05b29baf6', 'c7e17ba4-0328-45bf-8297-889abb72fce0', null, '2015-05-13 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('a11683ab-0bb3-4d8c-856d-62fcc7a66d08', 'c7e17ba4-0328-45bf-8297-889abb72fce0', null, '2015-05-13 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('5e1363f0-5fde-4c49-8022-dad68238e5bc', 'e6d323d5-d628-487e-b312-75ab02bd7b5d', '05f5cf7e-3390-400e-bf9c-a3aa009a9408', '2015-06-10 19:30', 'Generated Power - PHP 5.5 Generators', 'One of the new features that was introduced in PHP 5.5: Generators provide an iterable alternative to arrays, or to classes that implement the Iterator interface. At the simplest level, they don''t add anything new to PHP that you couldn''t already do before, simply returning values or key/value pairs to a loop; though they do give you options to perform certain iterative functions without the memory overheads of an array, or without the complexities of lots of boilerplate code that an Iterator class requires. But look more closely at Generators, and they can be used for much more complex purposes: from simulating arrays with duplicate keys, or keys that aren''t simple integer or string values, to accepting new data each iteration rather than simply returning it, so that you can actually modify their behaviour dynamically, or building Cooperative subroutines, even to simulating parallel processing. Generators add real power to PHP.'),
  ('d978a7b8-7932-4f3c-91ca-3f870b01ef34', 'e6d323d5-d628-487e-b312-75ab02bd7b5d', null, '2015-06-10 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('c8651103-0cc5-4f3b-87d3-25c6f50d7c68', 'e6d323d5-d628-487e-b312-75ab02bd7b5d', null, '2015-06-10 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('ffaf827d-ede1-413c-9c2b-d99514caba4c', 'dadf91a1-5b6d-49ab-9a24-f93f2ea890e7', '280968a8-5b04-467f-9fdf-4e5a2b9107fb', '2015-07-08 19:30', 'Why should developers care about SEO?', 'SEO the fifth most popular skill on LinkedIn. Many companies look for such skills in developers too. The purpose of the talk is to introduce developers to SEO, show them how it''s valuable for themselves, as well as their clients. After a brief overview of the fundamentals, the focus will be on technical aspects of SEO. That will show what developers can influence and improve aiding at providing more value to their clients.'),
  ('28c7ade0-77c2-4f3a-a848-aeac09deecb7', 'dadf91a1-5b6d-49ab-9a24-f93f2ea890e7', null, '2015-07-08 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('d55dd3df-9caa-43cd-b243-81f948bc8077', 'dadf91a1-5b6d-49ab-9a24-f93f2ea890e7', null, '2015-07-08 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('7e7a2b4a-b83c-40c3-ba95-4bd49e134045', 'd3426399-80c9-4fed-9cda-62f9c00fa3d1', 'e69c8202-66f2-4c0a-8843-f2babb7857da', '2015-08-12 19:30', 'PHP application monitoring with New Relic', 'Debugging code on your development machine is one thing, but how can you track the operation and performance of your application once it''s on a production server? New Relic provides mechanisms to profile performance, log error reporting, including full stack traces, view real load times in real user browsers, and 101 other things to help you improve the quality of your application and your user''s experience. During the session we''ll take a look at how to implement New Relic, the types of data and metrics which are available, and how deployment markers can help detect issues in newly released code before your users do. Disclaimer: I don''t work for New Relic and have no association with them (other than I pay them every month for their service), I just happen to really like their product and think it''s incredibly useful.'),
  ('b7b3926e-4a9e-4379-b48e-3047429df52b', 'd3426399-80c9-4fed-9cda-62f9c00fa3d1', null, '2015-08-12 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('dd87d383-ed11-4093-88a9-dda5a91b562f', 'd3426399-80c9-4fed-9cda-62f9c00fa3d1', null, '2015-08-12 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('d02d27cf-da9d-4e62-86c5-abb18d6446e4', '99f96738-7187-493c-9cc4-a78a2b1cb3c9', null, '2015-09-09 19:00', 'Arrival', null),
  ('5394181f-e343-4427-b52d-67e775c0b982', '99f96738-7187-493c-9cc4-a78a2b1cb3c9', null, '2015-09-09 19:25', 'Welcome announcement', null),
  ('bae0abe9-65cf-4fa9-858f-233d09ad3ae9', '99f96738-7187-493c-9cc4-a78a2b1cb3c9', 'b05b23cb-e7e3-439f-94fa-afbd8ca0a2a0', '2015-09-09 19:30', 'Secure your web application with two-factor authentication', 'Protecting your users'' data with just a username and password is no longer satisfactory. Two-factor authentication (2FA) is the primary method of countering the effects of stolen passwords, and it is easy to implement in your web application. In this session, we will discuss what two-factor authentication is, how it works, and the challenges associated with it. We will then look how to integrate two-factor authentication into your PHP application''s login workflow. We''ll consider a Google Authenticator implementation, so you can make your users'' accounts more secure. Finally, we will cover some plugins that WordPress & Drupal developers can use to enable this easily!'),
  ('81a2c194-16bc-4248-9556-e2411c8c9db9', '99f96738-7187-493c-9cc4-a78a2b1cb3c9', null, '2015-09-09 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('243723ec-ffad-4a5b-a8e3-102226970965', '99f96738-7187-493c-9cc4-a78a2b1cb3c9', null, '2015-09-09 20:45', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('01d44361-0725-49e5-ac81-8972338c3a12', 'd0ff76c4-53b7-4a40-ac2b-63458bec5f71', null, '2015-10-14 19:00', 'Arrival', null),
  ('3a7bd91f-ced9-42e5-aa55-e79c1d5b4d89', 'd0ff76c4-53b7-4a40-ac2b-63458bec5f71', null, '2015-10-14 19:25', 'Welcome announcement', null),
  ('309573cf-04be-4136-815c-157391d1cf80', 'd0ff76c4-53b7-4a40-ac2b-63458bec5f71', '296106e1-24c1-447f-8b6b-a3f15ebc9a6f', '2015-10-14 19:30', 'OWASP Proactive controls for developers - how to prevent the Top 10 Risks', 'OWASP Top Ten Risks is one of the most cited documents and describes the top 10 critical security vulnerabilities. In order to prevent them, developers must be aware of the controls they can incorporate in the early stages of software development lifecycle. To help this process, OWASP Top Ten Proactive Controls has been created. This is a list of security techniques that should be included in every software development project. The talk presents each control and then maps them to the OWASP risks they help preventing.'),
  ('47e4e1a7-99f9-4bc6-97f0-0cf7cfe2315a', 'd0ff76c4-53b7-4a40-ac2b-63458bec5f71', null, '2015-10-14 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('a1d4b8cf-a086-4fe6-8ff6-cc848fc5b5c7', 'd0ff76c4-53b7-4a40-ac2b-63458bec5f71', null, '2015-10-14 20:45', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('ead59ee2-1c42-447d-bd79-e289a050cc9f', '55855550-4ae3-4f9a-8ecd-e9a6a3722316', null, '2015-11-11 19:00', 'Arrival', null),
  ('9f1bd658-61b9-46a5-90a5-0f03ec898869', '55855550-4ae3-4f9a-8ecd-e9a6a3722316', null, '2015-11-11 19:25', 'Welcome announcement', null),
  ('e28310ce-d00a-4b59-8edd-33923e1046b7', '55855550-4ae3-4f9a-8ecd-e9a6a3722316', '8b66e801-bb3d-44ef-af81-4c3932563c4a', '2015-11-11 19:30', 'Using usability to develop your development', 'The problem is that we, as developers, understand how the web works. This is exaggerated by knowing in even more depth, how the application/website we are building works. We know how to add a user into a specific group, because we wrote the code that does it. We understand the intricacies of the systems we build, and often spend so long building them, and running through cycles of the processes to accomplish certain tasks, that we forget to think about the usability of our applications. Usability is often an after-thought of developers, or it is palmed off to a UI/UX expert. As developers, we need to get into the mindset of the person who will use the application, not the person who wants the application created, and incorporate proper usability into more than just form elements and removing all of the sliders that exist.'),
  ('43838a19-f7d2-46b8-9045-c21d60d140e6', '55855550-4ae3-4f9a-8ecd-e9a6a3722316', 'fc2ea51f-0dce-4d58-8426-2a2edfaaca6f', '2015-11-11 20:00', 'It''s a form, how hard can it be?', 'How hard is it to get a form right? It''s just some standard inputs and a button. Using some "rigorous" user testing with our "state of the art" user testing equipment we dug into how the default form options and builders on some leading frameworks went down with the general public. Is taking the easy way out as a developer making it harder for your users?'),
  ('c178ea44-9246-42d3-856e-321446593b15', '55855550-4ae3-4f9a-8ecd-e9a6a3722316', null, '2015-11-11 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('791aadf3-407b-4e3a-a620-cf9b34e5e0cd', '55855550-4ae3-4f9a-8ecd-e9a6a3722316', null, '2015-11-11 20:45', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('6ef0d0f2-d218-4b7a-bf56-28f0ef9c5395', 'ec2fdaa0-38d1-4553-bba1-a9d7c241272f', null, '2015-12-09 19:00', 'Arrival', null),
  ('e85a63f1-8bbc-44f4-8529-cac87562cab9', 'ec2fdaa0-38d1-4553-bba1-a9d7c241272f', null, '2015-12-09 19:25', 'Welcome announcement', null),
  ('a61eb19e-5fc5-44a9-ac91-0cc95a90a506', 'ec2fdaa0-38d1-4553-bba1-a9d7c241272f', '6f4b9d95-8b53-403e-808a-67943ca21869', '2015-12-09 19:30', 'PSR-7 and Middleware: The Future of PHP', 'While built for the web, PHP doesn''t abstract the actual HTTP messages. The new PSR-7 specification defines these, allowing you to code to shared interfaces instead of specific frameworks. Additionally, strong, shared HTTP abstractions give rise to a concept called "Middleware," software that sits between a request and a response. Come discover how PSR-7 works, learn about common middleware patterns, and discover how the two will change how you develop in PHP!'),
  ('b024125e-1bc5-4468-b5fa-e0ca57d0ba38', 'ec2fdaa0-38d1-4553-bba1-a9d7c241272f', null, '2015-12-09 20:30', '&pound;20 Amazon.co.uk gift voucher prize draw, courtesy of Spectrum IT', null),
  ('2a515101-bb0f-4f73-8cf3-e582d981fa0b', 'ec2fdaa0-38d1-4553-bba1-a9d7c241272f', null, '2015-12-09 20:45', '9pm Social @ Brewhouse Pompey (The White Swan)', null)
;

COMMIT;
