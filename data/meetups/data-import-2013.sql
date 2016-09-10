START TRANSACTION;

INSERT INTO location (id, name, address, url) VALUES
  ('6e883af6-dec4-4267-9281-1275675fa20e', 'The Red Lion', 'Horndean', 'https://www.facebook.com/The-Red-lion-Horndean-137362316314498/'),
  ('ddf9ed51-9958-4db4-a46a-5ae3420766db', 'Port 57', 'Portsmouth', 'http://www.port57.com/'),
  ('7e894174-e511-4ece-8513-68cdc8d49d16', 'Broad Oak Social Club', 'Airport Service Road, Portsmouth', 'http://www.broadoaksocialclub.net/'),
  ('fae3b251-0833-48dd-87f7-363ba1269517', 'Oasis Conference Centre', 'Arundel Street, PO1 1NH', 'http://www.oasisthevenue.co.uk/conference-centre/')
ON CONFLICT DO NOTHING;

INSERT INTO speaker (id, full_name, twitterhandle) VALUES
  ('d6f3e669-b09c-4e4c-91b5-0d55bc70bd6a', 'Lee Boynton', 'leeboynton'),
  ('fc2ea51f-0dce-4d58-8426-2a2edfaaca6f', 'Phil Bennett', 'phil_bennett'),
  ('e994d22f-f841-48e7-ac02-ffea772cd6b7', 'Eddie Abou-Jaoude', 'eddiejaoude'),
  ('2644f2d8-9ec4-46c1-9d7b-549c7f75c84e', 'Derick Rethans', 'derickr'),
  ('6409fda5-cb8f-421c-9d82-2aebfd229be9', 'Stuart Herbert', 'stuherbert'),
  ('933c8ae2-2cc7-4b46-97bb-e335530ea4a5', 'Michael Cullum', 'michaelcullumuk'),
  ('0ef6435d-b26a-4265-8a98-7dbb8cc42c65', 'James Titcumb', 'asgrim'),
  ('80845655-f3aa-40b7-897d-3159933f4f62', 'Robb Lewis', 'rmlewisuk'),
  ('f159dd3f-d948-4e28-b805-67352f8b0bdd', 'Rob Davis', 'therobyouknow'),
  ('a7566f7d-e4ca-4af0-9534-c445048c335f', 'Herb Miller', 'herb_miller'),
  ('9a81349b-b9f7-4131-a182-551bf5502085', 'Gareth Evans', 'garoevans')
ON CONFLICT DO NOTHING;

INSERT INTO meetup (id, location_id, from_date, to_date, topic) VALUES
  ('df04e686-28fa-479c-8eab-eb1a8f65fee3', '6e883af6-dec4-4267-9281-1275675fa20e', '2013-01-10 18:00', '2013-01-10 21:00', 'Prerequisite knowledge for working with ZF2'),
  ('a06e5397-a021-4c47-959e-27cb4b69e712', 'ddf9ed51-9958-4db4-a46a-5ae3420766db', '2013-03-23 15:00', '2013-03-23 18:00', null),
  ('e74a81aa-4dbd-44f2-8003-2a5ebe5bd144', '7e894174-e511-4ece-8513-68cdc8d49d16', '2013-07-27 14:00', '2013-07-27 18:00', null),
  ('5f63ba79-e62e-4fc6-bf08-ce0f8c607875', 'fae3b251-0833-48dd-87f7-363ba1269517', '2013-08-14 18:00', '2013-08-14 21:30', 'Better Testing Forum'),
  ('b94a834b-b59b-4152-9212-8e834d2466c3', 'fae3b251-0833-48dd-87f7-363ba1269517', '2013-09-11 19:00', '2013-09-11 21:30', null),
  ('dff61d4f-4f09-4acc-a9d7-2359e9f5f0ef', 'fae3b251-0833-48dd-87f7-363ba1269517', '2013-10-09 19:00', '2013-10-09 21:30', null),
  ('fb400bc7-f2ee-46ac-a936-d8c6d033428e', 'fae3b251-0833-48dd-87f7-363ba1269517', '2013-11-13 19:00', '2013-11-13 23:00', null),
  ('a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', 'fae3b251-0833-48dd-87f7-363ba1269517', '2013-12-11 19:00', '2013-12-11 23:00', null)
;

INSERT INTO eventbrite_data (id, meetup_id, url, eventbriteid) VALUES
  ('c581e74e-f05a-408a-98a7-33f7f3e2bcc8', 'a06e5397-a021-4c47-959e-27cb4b69e712', 'https://www.eventbrite.co.uk/event/5224635024', '5224635024'),
  ('05e42b33-7417-46e8-84ca-d2aad27031e5', 'e74a81aa-4dbd-44f2-8003-2a5ebe5bd144', 'https://www.eventbrite.co.uk/event/6901525649', '6901525649'),
  ('d3d1ce03-943c-4809-95ce-aa416f4b8c41', '5f63ba79-e62e-4fc6-bf08-ce0f8c607875', 'https://www.eventbrite.co.uk/event/6901521637', '6901521637'),
  ('f056667b-6918-4437-8808-f51aca632488', 'b94a834b-b59b-4152-9212-8e834d2466c3', 'https://www.eventbrite.co.uk/event/7896441469', '7896441469'),
  ('72a28f89-2d1b-4685-abed-b78d6e75cbae', 'dff61d4f-4f09-4acc-a9d7-2359e9f5f0ef', 'https://www.eventbrite.co.uk/event/8298393719', '8298393719'),
  ('d5ceb130-549f-402d-83af-af42d89ca9ff', 'fb400bc7-f2ee-46ac-a936-d8c6d033428e', 'https://www.eventbrite.co.uk/event/8752752719', '8752752719'),
  ('8ab4cb9e-719b-4000-a91d-a6e3d5eca3ed', 'a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', 'https://www.eventbrite.co.uk/event/8872569093', '8872569093')
;

INSERT INTO talk(id, meetup_id, speaker_id, time, title, abstract) VALUES
  ('fa262137-6801-4ddd-b056-f4ffe62482e9', 'df04e686-28fa-479c-8eab-eb1a8f65fee3', null, '2013-01-10 18:00', 'Tools and skills that Zend assumes you have before you start with ZF2', null),
  ('ae7caab4-deaa-4d3d-a592-1f44e8b39f28', 'df04e686-28fa-479c-8eab-eb1a8f65fee3', null, '2013-01-10 18:00', 'Other tools people currently use in development', null),
  ('59f6a308-c921-425f-820c-8fbe7aa504b0', 'df04e686-28fa-479c-8eab-eb1a8f65fee3', null, '2013-01-10 18:00', 'Getting to meet other developers', null),
  ('53712743-d746-4165-ad27-1ac893a56635', 'a06e5397-a021-4c47-959e-27cb4b69e712', 'd6f3e669-b09c-4e4c-91b5-0d55bc70bd6a', '2013-03-23 15:00', 'Integrating Node.js With PHP', null),
  ('3b3ed698-b6a7-4635-af2e-389c10ff61f4', 'a06e5397-a021-4c47-959e-27cb4b69e712', 'fc2ea51f-0dce-4d58-8426-2a2edfaaca6f', '2013-03-23 15:00', 'Creating a native iOS and Android App in 20 mins using HTML5, Yii and PhoneGap', null),
  ('c613c8d8-7f04-449e-9bc9-d909a6406e92', 'a06e5397-a021-4c47-959e-27cb4b69e712', 'e994d22f-f841-48e7-ac02-ffea772cd6b7', '2013-03-23 15:00', 'Zend Framework, The "M" in MVC', null),
  ('9e652fab-f88d-43a4-955c-42e946ffa832', 'e74a81aa-4dbd-44f2-8003-2a5ebe5bd144', '2644f2d8-9ec4-46c1-9d7b-549c7f75c84e', '2013-07-27 14:00', 'Introduction to MongoDB', null),
  ('5b910fb9-6e36-471c-a209-20b5429e5b5f', 'e74a81aa-4dbd-44f2-8003-2a5ebe5bd144', '6409fda5-cb8f-421c-9d82-2aebfd229be9', '2013-07-27 15:00', 'Automating Tests Using Storyplayer', null),
  ('b209dc25-4694-4fb5-b98c-133318843f5a', '5f63ba79-e62e-4fc6-bf08-ce0f8c607875', null, '2013-08-14 18:00', 'Better Testing Forum', 'A group discussion on various testing methodologies and how to implement them in your applications.'),
  ('4ec1cd7c-62c0-49fb-bd41-2655b42b20ff', 'b94a834b-b59b-4152-9212-8e834d2466c3', null, '2013-09-11 19:00', 'Arrival', null),
  ('5443f680-2ca4-4be7-a92b-defe6de50b2a', 'b94a834b-b59b-4152-9212-8e834d2466c3', null, '2013-09-11 19:20', 'Welcome announcement', null),
  ('bb0489eb-1ac8-4d05-97a2-6496a4a7ddfd', 'b94a834b-b59b-4152-9212-8e834d2466c3', '933c8ae2-2cc7-4b46-97bb-e335530ea4a5', '2013-09-11 19:30', 'PHP FIG: Standardising PHP', null),
  ('a6a5e69f-6629-49f6-982c-df14bc4a2338', 'b94a834b-b59b-4152-9212-8e834d2466c3', null, '2013-09-11 20:30', 'Break', null),
  ('53c804bb-8f9a-4802-a96d-2d48da446010', 'b94a834b-b59b-4152-9212-8e834d2466c3', '0ef6435d-b26a-4265-8a98-7dbb8cc42c65', '2013-09-11 20:40', 'Lightning Talk - Composer', null),
  ('862847c2-7b16-4524-9087-e61ccbc34155', 'b94a834b-b59b-4152-9212-8e834d2466c3', null, '2013-09-11 20:50', 'Closing Comments', null),
  ('aa8eba6d-55fe-4c6c-bcb2-2d7e359a6e94', 'b94a834b-b59b-4152-9212-8e834d2466c3', null, '2013-09-11 21:00', 'Social Gathering at <a href="http://brewhouseandkitchen.com/">Brewhouse Pompey</a>', null),
  ('e496143a-7fd3-4894-8211-10933c76adac', 'dff61d4f-4f09-4acc-a9d7-2359e9f5f0ef', '80845655-f3aa-40b7-897d-3159933f4f62', '2013-10-09 19:00', '1 million in 10 days', null),
  ('c8765e22-993d-4bd9-bf2c-808a4f1bcc56', 'dff61d4f-4f09-4acc-a9d7-2359e9f5f0ef', '0ef6435d-b26a-4265-8a98-7dbb8cc42c65', '2013-10-09 19:15', 'Errors, Exceptions and Logging', null),
  ('eb6f5363-fd00-4760-b8a6-b9ae3322b03b', 'fb400bc7-f2ee-46ac-a936-d8c6d033428e', 'f159dd3f-d948-4e28-b805-67352f8b0bdd', '2013-11-13 19:00', 'Building sites with Drupal, its Lego-like modules and Vagrant for general web development', null),
  ('8e541028-4e7a-4acb-9881-23b45e2537a6', 'fb400bc7-f2ee-46ac-a936-d8c6d033428e', 'a7566f7d-e4ca-4af0-9534-c445048c335f', '2013-11-13 19:45', 'Probably doing it wrong.', null),
  ('116cf323-46bf-4543-be16-783c783b18da', 'fb400bc7-f2ee-46ac-a936-d8c6d033428e', null, '2013-11-13 20:30', '9pm Social @ Brewhouse Pompey (The White Swan)', null),
  ('353a8480-03b6-4d84-b731-a0099ab6e2a4', 'a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', 'fc2ea51f-0dce-4d58-8426-2a2edfaaca6f', '2013-12-11 19:30', 'How to develop your development of being a developer without doing any developing', 'A light hearted look at being less shit, covering the periphery skills required including communication, delivery and not being a berk.'),
  ('6146d59d-70bd-49b6-b308-f542d4886280', 'a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', '9a81349b-b9f7-4131-a182-551bf5502085', '2013-12-11 20:30', 'PHP and Enums', 'This talk should begin with a very general introduction to Enums. What is an Enum and what is it for? Then, the direction should turn towards PHP, how does this work in PHP, where do I need it in PHP what are the benefits of using it. I then want to cover how you can use Enums, using SplEnum and talk very briefly about SplType.'),
  ('696bf46d-b7b8-4600-ab47-9bd0d76a0f29', 'a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', null, '2013-12-11 20:45', 'Pink elePHPant raffle:  Raffle tickets are &pound;1 per entry, or &pound;3 for 5 entries (a strip). Raffle tickets will be available at the event only.', null),
  ('6246374b-7321-428a-bde0-2f78f947549f', 'a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', null, '2013-12-11 20:45', 'Loads of prize giveaways from Zend, GitHub, JetBrains PhpStorm, O''Reilly, SpectrumIT, FTPloy', null),
  ('e193f226-dec8-4618-bc2f-79de1d0a8d8a', 'a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', null, '2013-12-11 20:45', 'Also some extra special Christmas treats!', null),
  ('7f908e64-1fe3-49da-a1fa-4d00fd41eb89', 'a6dec0ce-54a1-4e7f-9234-4c8b30cde92a', null, '2013-12-11 21:00', '9pm Social @ Brewhouse Pompey (The White Swan)', null)
;

COMMIT;
