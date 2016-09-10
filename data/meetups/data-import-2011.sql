START TRANSACTION;

INSERT INTO location (id, name, address, url) VALUES
  ('5d265b98-00da-48a9-907a-b72aecc2f681', 'The Deco', 'Portsmouth', 'https://www.facebook.com/TheDecoPub/'),
  ('4d102f97-ebc7-4b84-baac-5e4aff648601', 'Private location', 'Portsmouth', 'https://phphants.co.uk')
ON CONFLICT DO NOTHING;

INSERT INTO meetup (id, location_id, from_date, to_date, topic) VALUES
  ('a5e8430c-6cf3-4805-a372-03c109e6035a', '5d265b98-00da-48a9-907a-b72aecc2f681', '2011-03-12 12:00', '2011-03-12 15:00', 'Plan for the group'),
  ('dbc712e2-ab5b-466b-b8d9-89bdaa9f38ab', '5d265b98-00da-48a9-907a-b72aecc2f681', '2011-04-16 12:00', '2011-04-16 15:00', 'Zend Framework Introduction'),
  ('d93890af-b40d-43eb-92d0-b223efc60760', '5d265b98-00da-48a9-907a-b72aecc2f681', '2011-06-04 12:00', '2011-06-04 15:00', 'More Zend Framework'),
  ('85c98c54-9106-4dbe-9a6e-e6b5ec5bd5a1', '5d265b98-00da-48a9-907a-b72aecc2f681', '2011-07-23 12:00', '2011-07-23 15:00', 'GoDeploy'),
  ('a4d66501-3b8d-4959-99ee-efbd791e9866', '5d265b98-00da-48a9-907a-b72aecc2f681', '2011-08-20 12:00', '2011-08-20 15:00', 'GoDeploy and Git'),
  ('5877bd65-709e-42d7-9de2-c3be2ead0ba8', '5d265b98-00da-48a9-907a-b72aecc2f681', '2011-09-10 12:00', '2011-09-10 15:00', 'GoDeploy'),
  ('4f85e720-0312-48b0-afa0-c05f3f5fcf4d', '4d102f97-ebc7-4b84-baac-5e4aff648601', '2011-10-08 12:00', '2011-10-08 15:00', 'Existing projects'),
  ('c7a2e13c-0173-4aef-8ea5-37b2a9b6400c', '4d102f97-ebc7-4b84-baac-5e4aff648601', '2011-11-19 12:00', '2011-11-19 15:00', 'GoDeploy roadmap');
;

INSERT INTO talk(id, meetup_id, speaker_id, time, title, abstract) VALUES
  ('8e056f57-aaf5-488c-9bd0-475b51ff74f9', 'a5e8430c-6cf3-4805-a372-03c109e6035a', null, '2011-03-12 12:00', 'Set up a MediaWiki for planning', null),
  ('4715b9cd-fc31-4ec6-a31b-8528e31b2a64', 'a5e8430c-6cf3-4805-a372-03c109e6035a', null, '2011-03-12 12:00', 'Decided on monthly meetups', null),
  ('260269cd-920d-4199-9f64-14b15c3da4fd', 'dbc712e2-ab5b-466b-b8d9-89bdaa9f38ab', null, '2011-04-16 12:00', 'Decided on group name PHP Hampshire', null),
  ('68ad7ceb-8704-4213-88c2-2f6cac6f055e', 'dbc712e2-ab5b-466b-b8d9-89bdaa9f38ab', null, '2011-04-16 12:00', 'Logo redesigned with lightning', null),
  ('ca821143-610f-4898-93b7-e60ae636cb2a', 'dbc712e2-ab5b-466b-b8d9-89bdaa9f38ab', null, '2011-04-16 12:00', 'Talked about possibility of setting up a mailing list', null),
  ('a0963d6a-4054-479e-8d3e-30c292757864', 'dbc712e2-ab5b-466b-b8d9-89bdaa9f38ab', null, '2011-04-16 12:00', 'Zend Framework 1 introduction', null),
  ('3cb8f881-8043-422d-9077-0ef8a03596c8', 'dbc712e2-ab5b-466b-b8d9-89bdaa9f38ab', null, '2011-04-16 12:00', 'PHP additions - closures, goto, etc.', null),
  ('53eb4743-e8d8-4c52-9a57-39aaebf5e3b9', 'd93890af-b40d-43eb-92d0-b223efc60760', null, '2011-06-04 12:00', 'Minecraft', null),
  ('52be1477-ca3b-4632-bf92-0cb27e4d264c', 'd93890af-b40d-43eb-92d0-b223efc60760', null, '2011-06-04 12:00', 'ZF View Helpers', null),
  ('5407bed1-c138-4a91-b6d1-73fc5cf6fb74', 'd93890af-b40d-43eb-92d0-b223efc60760', null, '2011-06-04 12:00', 'Pagoda Box and scalable cloud PHP hosting', null),
  ('eb1ffbe1-794c-4c87-999a-50be93b8921f', 'd93890af-b40d-43eb-92d0-b223efc60760', null, '2011-06-04 12:00', 'Ideas for collaborative projects e.g. Pompey Music Forum', null),
  ('9dc02b9f-fe67-40cb-80a5-38ad0f84dc6e', 'd93890af-b40d-43eb-92d0-b223efc60760', null, '2011-06-04 12:00', 'PHP extensions in C', null),
  ('86b779c3-6a6f-41e3-bcbd-78f2400d1547', '85c98c54-9106-4dbe-9a6e-e6b5ec5bd5a1', null, '2011-07-23 12:00', 'Discussed GoDeploy and distribution of jobs', null),
  ('f6f3d627-8488-418f-9882-460a31990a86', '85c98c54-9106-4dbe-9a6e-e6b5ec5bd5a1', null, '2011-07-23 12:00', 'Javascript Frameworks - Dojo, JQuery, Prototype+Scriptaculous', null),
  ('69ee9215-40c4-4a76-9cee-d30e9508ac6f', '85c98c54-9106-4dbe-9a6e-e6b5ec5bd5a1', null, '2011-07-23 12:00', 'Tablets (e.g. Samsung Galaxy Tabs)', null),
  ('a3dba59c-319b-414d-8385-d95987596ea3', 'a4d66501-3b8d-4959-99ee-efbd791e9866', null, '2011-08-20 12:00', 'GoDeploy issues', null),
  ('7625bc3f-61d1-4818-8cff-0a8acbe9eae2', 'a4d66501-3b8d-4959-99ee-efbd791e9866', null, '2011-08-20 12:00', 'Git usage', null),
  ('3cf51b4e-f493-4095-a612-16af14cef446', '5877bd65-709e-42d7-9de2-c3be2ead0ba8', null, '2011-09-10 12:00', 'GoDeploy outstanding bugs and new features', null),
  ('97a11a2d-0703-4fe0-848d-0be567b4fe1b', '5877bd65-709e-42d7-9de2-c3be2ead0ba8', null, '2011-09-10 12:00', 'Zend Certification Examination', null),
  ('b1503939-8bad-4a2b-8b3b-c09e1b4d7f92', '5877bd65-709e-42d7-9de2-c3be2ead0ba8', null, '2011-09-10 12:00', 'Should GoDeploy support Windows servers', null),
  ('96c18e35-df02-4840-8671-7aad413cfc7a', '5877bd65-709e-42d7-9de2-c3be2ead0ba8', null, '2011-09-10 12:00', 'How git flow could help GoDeploy', null),
  ('01072c5b-b69b-4522-8a58-dee11e5aef02', '4f85e720-0312-48b0-afa0-c05f3f5fcf4d', null, '2011-10-08 12:00', 'ZF documentation and best practise', null),
  ('739f41a9-0cc8-4c66-99a7-0ef2ab9aa3e1', '4f85e720-0312-48b0-afa0-c05f3f5fcf4d', null, '2011-10-08 12:00', 'Work on GoDeploy', null),
  ('38c5daf3-a75a-4a8d-9e83-7b94ca4b819e', 'c7a2e13c-0173-4aef-8ea5-37b2a9b6400c', null, '2011-11-19 12:00', 'Monetisation of GoDeploy', null)
;

COMMIT;
