START TRANSACTION;

INSERT INTO location (id, name, address, url) VALUES
  ('5d265b98-00da-48a9-907a-b72aecc2f681', 'The Deco', 'Portsmouth', 'https://www.facebook.com/TheDecoPub/')
ON CONFLICT DO NOTHING;

INSERT INTO meetup (id, location_id, from_date, to_date, topic) VALUES
  ('4c2faf0c-c335-4929-9f14-09befad72c51', '5d265b98-00da-48a9-907a-b72aecc2f681', '2012-03-24 12:00', '2012-03-24 15:00', 'PHP extensions'),
  ('201e5429-6f26-46dd-9fea-661cd7094cb4', '5d265b98-00da-48a9-907a-b72aecc2f681', '2012-04-21 12:00', '2012-04-21 15:00', 'Gearman'),
  ('9736fc3a-466a-4408-9b9b-f6a1fc2e39cc', '5d265b98-00da-48a9-907a-b72aecc2f681', '2012-12-15 12:00', '2012-12-15 15:00', 'PHP Hampshire!')
;

INSERT INTO talk(id, meetup_id, speaker_id, time, title, abstract) VALUES
  ('3361aab3-6a0c-4509-b5b2-7fb2136a7ecd', '4c2faf0c-c335-4929-9f14-09befad72c51', null, '2012-03-24 12:00', 'Basic PHP extensions (using C)', null),
  ('7acb4a0e-5e8d-420d-b6b5-2c1d022a75e4', '4c2faf0c-c335-4929-9f14-09befad72c51', null, '2012-03-24 12:00', 'Gearman introduction', null),
  ('c4b1e959-0117-44ad-b8f0-f5bab9c832a1', '201e5429-6f26-46dd-9fea-661cd7094cb4', null, '2012-04-21 12:00', 'Talked about Gearman in depth', null),
  ('3f5f2e57-80d3-4811-b7dd-9fcce10672c3', '201e5429-6f26-46dd-9fea-661cd7094cb4', null, '2012-04-21 12:00', 'Raytracing vs polygon rendering in 3D', null),
  ('5673ec42-4bd1-4313-97b4-ed04b1e1581a', '9736fc3a-466a-4408-9b9b-f6a1fc2e39cc', null, '2012-12-15 12:00', 'How can we spread the word of the group?', null),
  ('4c9c419c-6a9f-46a1-902a-c7424958908b', '9736fc3a-466a-4408-9b9b-f6a1fc2e39cc', null, '2012-12-15 12:00', 'Community - what do people think of the site? What improvements can we make?', null),
  ('d54f2ebc-88aa-4fb6-a371-7db22fef4d2b', '9736fc3a-466a-4408-9b9b-f6a1fc2e39cc', null, '2012-12-15 12:00', 'Popular frameworks - ZF2, Symfony2, Silex etc.', null),
  ('31117fd0-2eae-47e8-b56c-fd1f4f9aa1e6', '9736fc3a-466a-4408-9b9b-f6a1fc2e39cc', null, '2012-12-15 12:00', 'Events', null),
  ('2c4c024d-af83-4089-88ee-d6c1a84bc30c', '9736fc3a-466a-4408-9b9b-f6a1fc2e39cc', null, '2012-12-15 12:00', 'Sponsorship', null)
;

COMMIT;
