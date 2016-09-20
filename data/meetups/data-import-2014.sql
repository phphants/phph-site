START TRANSACTION;

INSERT INTO location (id, name, address, url) VALUES
  ('fae3b251-0833-48dd-87f7-363ba1269517', 'Oasis Conference Centre', 'Arundel Street, PO1 1NH', 'http://www.oasisthevenue.co.uk/conference-centre/')
ON CONFLICT DO NOTHING;

INSERT INTO speaker (id, full_name, twitterhandle) VALUES
  ('933c8ae2-2cc7-4b46-97bb-e335530ea4a5', 'Michael Cullum', 'michaelcullumuk'),
  ('225308e2-face-4ae9-bb28-c367591b34ea', 'Simon Holywell', 'Treffynnon'),
  ('5c1a3315-8713-4115-915e-8cec8c9ef83a', 'Massi Cavicchioli', 'ArchMassi'),
  ('d6758e42-35e6-4ced-a97c-07a6830507a7', 'Kimberley Ford', 'luco_el_loco'),
  ('ad537f3c-9cdd-4693-9961-911a87ba595c', 'Rebecca Short', 'RebeccaShortSEO'),
  ('91fafc3e-e71b-4faa-a13d-6d03ee23399d', 'Konstantin Kudryashov', 'everzet'),
  ('01c4dd4a-6882-4fbd-8592-bf4690ce6ac5', 'Michael Heap', 'mheap'),
  ('9a81349b-b9f7-4131-a182-551bf5502085', 'Gareth Evans', 'garoevans'),
  ('488dc3f2-818b-4a87-a976-d2082feb23d1', 'Jenny Wong', 'miss_jwo'),
  ('aace67f8-7d77-4668-9ae6-939ece82c6b0', 'Davey Shafik', 'dshafik'),
  ('d7b8a469-9b23-48f1-9c22-f33bf0e7d81f', 'Dave Hulbert', 'dave1010'),
  ('9bfe92df-5d99-4ee9-9232-78fe7b6b89be', 'Gary Hockin', 'GeeH'),
  ('55c51011-cfc3-4dad-9106-5d1bee954f36', 'David Yell', 'YellDavid'),
  ('3ed07ac6-cff5-4196-bc28-31660c1c7fe1', 'Andy Piper', 'andypiper')
ON CONFLICT DO NOTHING;

INSERT INTO meetup (id, location_id, from_date, to_date, topic) VALUES
  ('a9b3662d-6f13-45b6-84ae-5c224b1a7745', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-01-08 19:00', '2014-01-08 23:00', null),
  ('da66740a-5b72-4d1f-b807-e067e8372858', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-02-12 19:00', '2014-02-12 23:00', null),
  ('4df7964e-c94a-45e3-a7f8-93875a54261b', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-03-12 19:00', '2014-03-12 23:00', null),
  ('270772be-6fd8-4ff3-baf5-1f7cc6781603', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-04-09 19:00', '2014-04-09 23:00', null),
  ('70a9d9fe-a7aa-4636-a33b-993b887aaf08', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-05-14 19:00', '2014-05-14 23:00', null),
  ('cbda81ec-1ed4-4469-92b3-6fb2b5cf5325', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-06-11 19:00', '2014-06-11 23:00', null),
  ('33cb185e-3476-41c8-b972-028e143bd905', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-07-09 19:00', '2014-07-09 23:00', null),
  ('7dbb4e1b-5c15-4a0d-afa6-090eebe661ac', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-08-13 19:00', '2014-08-13 23:00', null),
  ('c95561f6-5a24-4afd-91c2-2b017ace8bc8', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-09-10 19:00', '2014-09-10 23:00', null),
  ('9c62e65b-0ef7-4e7e-9747-7698168d873b', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-10-08 19:00', '2014-10-08 23:00', null),
  ('75aa4401-ea98-4ffd-aaf8-6b3f3be59719', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-11-12 19:00', '2014-11-12 23:00', null),
  ('ab756464-b899-4504-ae72-98f08da0433e', 'fae3b251-0833-48dd-87f7-363ba1269517', '2014-12-10 19:00', '2014-12-10 23:00', null)
;

INSERT INTO eventbrite_data (id, meetup_id, url, eventbriteid) VALUES
  ('78ea67f4-e05a-46f2-a665-8edba2cdd33f', 'a9b3662d-6f13-45b6-84ae-5c224b1a7745', 'https://www.eventbrite.co.uk/event/9904039248', '9904039248'),
  ('e7af209f-2627-4c63-8583-9eec6d84a23d', 'da66740a-5b72-4d1f-b807-e067e8372858', 'https://www.eventbrite.co.uk/event/9904055296', '9904055296'),
  ('092bb84c-dd6e-415f-8fd0-5f6fb6e1717a', '4df7964e-c94a-45e3-a7f8-93875a54261b', 'https://www.eventbrite.co.uk/event/9904061314', '9904061314'),
  ('f9407ee5-de6c-48bc-8429-62aec24408d5', '270772be-6fd8-4ff3-baf5-1f7cc6781603', 'https://www.eventbrite.co.uk/event/10882623219', '10882623219'),
  ('ef50b47c-dd0b-401d-8200-3908e257aee5', '70a9d9fe-a7aa-4636-a33b-993b887aaf08', 'https://www.eventbrite.co.uk/event/10882657321', '10882657321'),
  ('06217fae-55fc-41a7-b875-dc678b03b1a7', 'cbda81ec-1ed4-4469-92b3-6fb2b5cf5325', 'https://www.eventbrite.co.uk/event/11690603911', '11690603911'),
  ('c62fa6f6-1cfa-4be1-9aed-d93f525a2b8c', '33cb185e-3476-41c8-b972-028e143bd905', 'https://www.eventbrite.co.uk/event/11915077317', '11915077317'),
  ('08d34337-6bf8-4ef9-ad7b-98a215cbc28d', '7dbb4e1b-5c15-4a0d-afa6-090eebe661ac', 'https://www.eventbrite.co.uk/event/11915885735', '11915885735'),
  ('438c21dd-6d92-464c-a70e-0cbd5928ea22', 'c95561f6-5a24-4afd-91c2-2b017ace8bc8', 'https://www.eventbrite.co.uk/event/12685993147', '12685993147'),
  ('8a3315af-e5aa-473c-bb02-1d9150a75a31', '9c62e65b-0ef7-4e7e-9747-7698168d873b', 'https://www.eventbrite.co.uk/event/12998724535', '12998724535'),
  ('4d7c2e16-c397-4084-bea9-bf2d9348f20e', '75aa4401-ea98-4ffd-aaf8-6b3f3be59719', 'https://www.eventbrite.co.uk/event/13586326067', '13586326067'),
  ('73cbc49c-d6b4-4840-a1fa-fe4d4fbde47e', 'ab756464-b899-4504-ae72-98f08da0433e', 'https://www.eventbrite.co.uk/event/13601216605', '13601216605')
;

INSERT INTO talk(id, meetup_id, speaker_id, time, title, abstract) VALUES
  ('b4b28e94-dadf-45f8-950d-3a5ccdca0fa9', 'a9b3662d-6f13-45b6-84ae-5c224b1a7745', '933c8ae2-2cc7-4b46-97bb-e335530ea4a5', '2014-01-08 19:30', 'Why Open Source is good for you (and your organisation)', null),
  ('19aedef7-4231-46b9-b980-745513db8488', 'a9b3662d-6f13-45b6-84ae-5c224b1a7745', null, '2014-01-08 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('4ceaf72d-56ca-4852-b3b4-0067f1aca27c', 'da66740a-5b72-4d1f-b807-e067e8372858', '225308e2-face-4ae9-bb28-c367591b34ea', '2014-02-12 19:30', 'Functional PHP', 'In the PHP world functions are generally sneered at due to their simplicity and perceived as an evil side effect of spaghetti code. This is not necessarily the case however as when functions are combined in a logical manner they can be very powerful.<br /><br />In fact they can be deployed to great effect in all manner of applications to create advanced and potentially less error prone software.<br /><br />This talk will take the form of a gentle introduction to functional programming concepts in a PHP context. It will cater to a variety of levels of knowledge. Right from those who have never heard of functional programming to coders who have been practicing aspects for years in other languages (JavaScript!) - perhaps without even knowing.<br /><br />During my talk you''ll hear some history, functional theory (introduced gently I promise) and of course some practical examples. You definitely do not need to be a mathematician or expert/functional coder to enjoy this session.'),
  ('7f4d695e-e846-45cf-9547-e61838c03fa8', 'da66740a-5b72-4d1f-b807-e067e8372858', null, '2014-02-12 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('f5b185e8-671d-4055-aa80-2972ec3b3f94', '4df7964e-c94a-45e3-a7f8-93875a54261b', '5c1a3315-8713-4115-915e-8cec8c9ef83a', '2014-03-12 19:30', 'The Great PHP Hampshire Zend elePHPant Hunt', 'We''ve got something a little different this time around! We''ve got a Zend elePHPant hunt. <em>You''ll need to bring a laptop and have downloaded the Zend Server installer beforehand.</em><br /><br /><strong>What is an elePHPant Hunt?</strong><br />It''s your opportunity to get your hands on "Chilli" the Red elePHPant with the help of Zend. You''ll need to bring a laptop and have downloaded a copy of Zend Server to take part. You''ll install Zend Server, and a representative from Zend will ask you a few questions about Zend Server. When you have completed the challenge, you will be entered in the draw to win a Red ElePHPant! Simple as that!'),
  ('b1e8736a-43b2-4cd9-902d-125d44890dbd', '4df7964e-c94a-45e3-a7f8-93875a54261b', 'd6758e42-35e6-4ced-a97c-07a6830507a7', '2014-03-12 20:40', 'Kim''s Car:An Introduction to Object Oriented Programming in PHP', null),
  ('1b7f76b0-d0bb-4902-8999-df1d6ec0d0f7', '4df7964e-c94a-45e3-a7f8-93875a54261b', 'ad537f3c-9cdd-4693-9961-911a87ba595c', '2014-03-12 20:50', 'Coding with SEO in mind', null),
  ('d4fc395f-06a8-4285-b492-3204edcba2e3', '4df7964e-c94a-45e3-a7f8-93875a54261b', null, '2014-03-12 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('99625298-d743-44c0-975f-5feb06830476', '270772be-6fd8-4ff3-baf5-1f7cc6781603', '91fafc3e-e71b-4faa-a13d-6d03ee23399d', '2014-04-09 19:30', 'Enabling Agile through enabling BDD in PHP projects', 'What is the purpose of BDD and how it fits into the Agile development? If you ever wondered what are the benefits of BDD or why should you care about tools like Behat or PhpSpec, this talk will try to guide you through the reasoning and goals of modern Agile practices and tools in PHP.'),
  ('622308d1-199f-4fcd-a0ca-16e0b26b07fb', '270772be-6fd8-4ff3-baf5-1f7cc6781603', null, '2014-04-09 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('fbcdab59-c3ec-4b16-8467-ec3d64a29122', '70a9d9fe-a7aa-4636-a33b-993b887aaf08', '01c4dd4a-6882-4fbd-8592-bf4690ce6ac5', '2014-05-14 19:30', 'Bring Your Application Into 2014', 'Over the last few years, the PHP ecosystem''s really kicked it up a gear when it comes to good application design, unit testing and dependency management. Unfortunately, some of us are still stuck working with code that''s 5 years old and has never heard of dependency injection. How can we use all these wonderful new tricks when our existing codebase is so bad? There are ways to do it. Some of them aren''t pretty, and some of them feel plain wrong, but they mean that your code is at least a little bit more stable than they were before you started. Over the last 12 months I''ve been on a mission to improve a legacy code base. This includes eradicating singletons and reducing the dependencies of our unit tests (no need to connect to a DB any more!). Let me help you do the same for your code base too.'),
  ('94aa8d10-ec63-4938-ade3-874ac2756f91', '70a9d9fe-a7aa-4636-a33b-993b887aaf08', '9a81349b-b9f7-4131-a182-551bf5502085', '2014-05-14 19:30', 'How I use PHPStorm day-to-day', 'Lightning talk from Gareth on PHP Storm'),
  ('335fc9bd-5134-4963-a79a-498b008c2d40', '70a9d9fe-a7aa-4636-a33b-993b887aaf08', null, '2014-05-14 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('6690297b-9315-4c9a-9e95-f7121f2fd6ba', 'cbda81ec-1ed4-4469-92b3-6fb2b5cf5325', '488dc3f2-818b-4a87-a976-d2082feb23d1', '2014-06-11 19:30', 'Inclusivity and the PHP Community', 'Many people have preconceptions of PHP Women. They wonder what the point of the group is, or believe that PHP Women is a feminist tech group of sorts. Jenny has spent time manning numerous conference stands, running uncon rooms and spending conference socials explaining to individuals what PHP Women is about and why it is important such a group exists. At PHPNE14 Jenny decided to give a talk entitled: PHP Women - Ask Me Anything. There she shared her skepticism, experiences & take on how PHP Women is empowering people to get more involved within the tech community. Following an invitation from PHP Hampshire, Jenny will be travelling down to share and discuss her thoughts on the matter. Questions and discussions are welcomed and much appreciated. If you would like to ask a question in advance (you can ask anonymously), please complete <a href="https://docs.google.com/forms/d/1CVW7WqcLECuSJ18Wdre0HSNPwqIaeR9K77bfRUKXtb0/viewform?usp=send_form">this form</a>.'),
  ('bec04bed-79ee-4024-95e9-6cc59875605f', 'cbda81ec-1ed4-4469-92b3-6fb2b5cf5325', null, '2014-06-11 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('86296d3a-7dbd-42ab-9e00-12dfbf92c303', '33cb185e-3476-41c8-b972-028e143bd905', 'aace67f8-7d77-4668-9ae6-939ece82c6b0', '2014-07-09 19:30', 'PHP: Under the Hood', 'Performance issues can be caused by many things, from database interactions, web services, disk i/o and, less frequently, the code itself. We would typically turn to a profiler like xhprof to diagnose these issues, but what if the bottleneck is PHP itself, where do you turn? This talk will take that inspection a step further and look under the hood of PHP, at the C internals of how things tick. This talk covers what every PHP developer should know about their tools — like what''s really going on when you use double quotes vs single quotes. If you’ve ever wanted to know exactly what your code is doing, and why ++\$i is faster than \$i++, this talk is for you.'),
  ('129c9d8d-1b9c-478b-bd31-a65a8861b6fe', '33cb185e-3476-41c8-b972-028e143bd905', null, '2014-07-09 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('d25bc7ac-ea18-4c5b-ae71-fba499562bd7', '7dbb4e1b-5c15-4a0d-afa6-090eebe661ac', 'd7b8a469-9b23-48f1-9c22-f33bf0e7d81f', '2014-08-13 19:30', 'The Benefit of Sneezing Code Into an Editor vs Clean Code', 'Balancing technical debt and getting things done is one of the hardest problems we have. When should we write beautiful, elegant, clean code and when should we just hammer away blindly at the keyboard until it''s done? This talk goes in to why this balance is so difficult and covers everything from estimations to refactoring and testing, with a focus on real world PHP apps.'),
  ('3e825501-bb42-4bc2-b4ce-79bc3f2de0c4', '7dbb4e1b-5c15-4a0d-afa6-090eebe661ac', null, '2014-08-13 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('499f7666-c17a-4d92-9411-b74fd3273443', 'c95561f6-5a24-4afd-91c2-2b017ace8bc8', '9bfe92df-5d99-4ee9-9232-78fe7b6b89be', '2014-09-10 19:30', 'Introducing the OWASP Top 10', 'Every year the OWASP community releases a Top 10 List of what it considers are the most critical web application security flaws. Join us as we step through the current OWASP Top 10 vulnerabilities, explaining what they are and how they can affect your PHP application. We''ll take a quickfire look at all 10 security concerns complete with examples and best practices. You''ll leave the talk with a basic understanding of each flaw giving you a great grounding to audit your own applications and an impetus to learn more about website security.'),
  ('42e59f74-f106-4cf1-a264-653c7a133cec', 'c95561f6-5a24-4afd-91c2-2b017ace8bc8', null, '2014-09-10 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('003fd39e-ecc1-4a5a-9c9a-dfdd70cdad44', '9c62e65b-0ef7-4e7e-9747-7698168d873b', '55c51011-cfc3-4dad-9106-5d1bee954f36', '2014-10-08 19:30', 'Don''t code, bake. An introduction to CakePHP', 'An introduction to CakePHP, a rapid application development PHP framework. We are all being asked to do more with less these days. Learn about how RAD can work for you to make people happy.'),
  ('f01a91fb-a578-4be7-a06a-9037f3fc4305', '9c62e65b-0ef7-4e7e-9747-7698168d873b', null, '2014-10-08 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('1ab65155-dbbf-4c56-9876-97cfa24d427c', '75aa4401-ea98-4ffd-aaf8-6b3f3be59719', '933c8ae2-2cc7-4b46-97bb-e335530ea4a5', '2014-11-12 19:30', 'Converting a website to a new religion: Symfony', 'When you have a huge website and you decide to make the move to Symfony, it can be a very daunting prospect of having to rewrite your entire website on top of the Symfony framework. We’ll go through how this can be done as smoothly as possible with a large enterprise size website, piece by piece, deploying your site every step of the way, following along with the example of phpBB, an organisation going through this process, to discover the right and wrong way to go about it and many tools you can use on enterprise-scale Symfony applications to help along the way.'),
  ('84f1a1b9-9c90-45cf-8607-14a071a7b81f', '75aa4401-ea98-4ffd-aaf8-6b3f3be59719', null, '2014-11-12 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('2a6e3fa9-7127-4ae4-835c-c7c07a7da1ff', 'ab756464-b899-4504-ae72-98f08da0433e', '3ed07ac6-cff5-4196-bc28-31660c1c7fe1', '2014-12-10 19:30', 'Connecting to the Pulse of the Planet', 'Twitter is a global, real-time platform; an indispensable companion to life in the moment and what’s happening in the world at any given time. The Twitter APIs and platform give developers the opportunity to tap into the pulse of the planet and use that data in innovative ways. This talk will provide some examples, and look at how to take advantage of the platform through Twitter APIs.'),
  ('38d4cb68-8123-4e09-b2c6-d5ec3fdd1360', 'ab756464-b899-4504-ae72-98f08da0433e', null, '2014-12-10 20:45', 'Super Special Xmas Prize Draws - with prizes from Spectrum IT, GitHub, php|architect, JetBrains, O''Reilly and more!', null),
  ('03f1f21b-dc3f-474f-9ea8-0f7abd831fe2', 'ab756464-b899-4504-ae72-98f08da0433e', null, '2014-12-10 20:45', 'elePHPant Raffles!', null),
  ('f8cf4010-c7d0-44b4-b830-3b5a8e0c3290', 'ab756464-b899-4504-ae72-98f08da0433e', null, '2014-12-10 20:45', 'Mince pies and yule logs!', null),
  ('c2f58d16-7e37-408f-b62c-bd493aec1ff3', 'ab756464-b899-4504-ae72-98f08da0433e', null, '2014-12-10 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null)
;

COMMIT;
