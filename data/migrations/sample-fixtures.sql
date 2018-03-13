INSERT INTO location (id, name, address, url) VALUES
    ('6cf0fc0a-7ad4-4bf2-85c2-b63149f04a6b', 'Great Venue', '123 Main Street', 'https://great-venue.com');
INSERT INTO meetup (id, location_id, from_date, to_date) VALUES
    ('4264dea0-d91b-4105-8209-8ceb52c8a4ef', '6cf0fc0a-7ad4-4bf2-85c2-b63149f04a6b', '2017-01-01 19:00:00', '2017-01-01 23:00:00'),
    ('8ab4acd5-9c00-4974-bad7-ac4bc53cc154', '6cf0fc0a-7ad4-4bf2-85c2-b63149f04a6b', '2100-12-31 19:00:00', '2100-01-31 23:00:00');
INSERT INTO speaker (id, full_name, twitterhandle, biography) VALUES
    ('396a64cc-bede-4e85-adb4-73179f0e39ea', 'Sally Smith', 'sallysmith_phphants_speaker', 'Some bio text blah'),
    ('e2690333-813f-4d52-bf5a-5ab13d4425ec', 'Joe Tibbs', 'joetibbs_phphants_speaker', 'Some bio text blah');
INSERT INTO talk (id, meetup_id, speaker_id, time, title, abstract) VALUES
    ('fb05d39d-2c1f-414c-9ca7-2254b582d628', '4264dea0-d91b-4105-8209-8ceb52c8a4ef', NULL, '2017-01-01 19:00:00', 'Arrival with beer and pizza', NULL),
    ('697caf14-f5f9-4ac3-823d-b3cf72f83349', '4264dea0-d91b-4105-8209-8ceb52c8a4ef', NULL, '2017-01-01 19:30:00', 'Welcome announcement', NULL),
    ('c98c037f-0ef5-4cb3-a447-5bc248f82176', '4264dea0-d91b-4105-8209-8ceb52c8a4ef', '396a64cc-bede-4e85-adb4-73179f0e39ea', '2017-01-01 19:35:00', 'My great talk', 'Abstract for the talk'),
    ('61ba5152-8f1e-48c4-a07a-001747c8a1ca', '4264dea0-d91b-4105-8209-8ceb52c8a4ef', NULL, '2017-01-01 20:30:00', 'Closing comments and prize draws', NULL),
    ('cf1b1c2b-b53f-4a04-89ce-cf8fc41ba454', '4264dea0-d91b-4105-8209-8ceb52c8a4ef', NULL, '2017-01-01 20:45:00', 'Social @ Brewhouse Pompey', NULL),
    ('0e3fa29d-be01-4342-860b-2c127072bbbf', '8ab4acd5-9c00-4974-bad7-ac4bc53cc154', NULL, '2100-12-31 19:00:00', 'Arrival with beer and pizza', NULL),
    ('c566d45a-c8fe-47a3-8190-f931c2b601a5', '8ab4acd5-9c00-4974-bad7-ac4bc53cc154', NULL, '2100-12-31 19:30:00', 'Welcome announcement', NULL),
    ('cded748c-9e48-4943-a2cd-7123ed453643', '8ab4acd5-9c00-4974-bad7-ac4bc53cc154', 'e2690333-813f-4d52-bf5a-5ab13d4425ec', '2100-12-31 19:35:00', 'Talking for fun and profit', 'The talk is fantastic, come watch it'),
    ('42dd2bb9-c5f9-4eba-8e0f-da5f245a7797', '8ab4acd5-9c00-4974-bad7-ac4bc53cc154', NULL, '2100-12-31 20:30:00', 'Closing comments and prize draws', NULL),
    ('0092e8aa-6a49-43dc-a20d-4b76e613a71e', '8ab4acd5-9c00-4974-bad7-ac4bc53cc154', NULL, '2100-12-31 20:45:00', 'Social @ Brewhouse Pompey', NULL);
-- Both password hashes are simply "password"
INSERT INTO "user" (id, email, password, role, display_name) VALUES
    ('c90699ed-3b60-4df5-a5e3-7911abd9cc99', 'admin@phphants.co.uk', '$2y$10$kvn.DfljMoy0Ihppde8IQ.lMea9w4vmz/Y.1tCPaPXWQN9X/.fWra', 'administrator', 'Admin User'),
    ('ef0ac6ce-4e52-42cd-a9d4-e9a376627a67', 'attendee@phphants.co.uk', '$2y$10$UKPTDNVMc8z/XehQM5RZBOhrNpHxpEbh2BmCwWAGKf124eMR6nCDi', 'attendee', 'General Attendee');
INSERT INTO meetup_attendees (id, meetup_id, user_id) VALUES
    ('c8538b57-e848-4104-b541-c6c542ec65e9', '4264dea0-d91b-4105-8209-8ceb52c8a4ef', 'c90699ed-3b60-4df5-a5e3-7911abd9cc99'),
    ('5ebf3387-4be7-4068-83e2-bc70d2123d74', '4264dea0-d91b-4105-8209-8ceb52c8a4ef', 'ef0ac6ce-4e52-42cd-a9d4-e9a376627a67'),
    ('eda4afae-1753-434f-88a4-9a185def7ecf', '8ab4acd5-9c00-4974-bad7-ac4bc53cc154', 'c90699ed-3b60-4df5-a5e3-7911abd9cc99');
