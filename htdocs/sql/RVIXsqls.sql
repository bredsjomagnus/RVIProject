use RVIProject;
-- use maaa16;

SELECT * FROM RVIXarticle WHERE tags LIKE '%rpg%';
SELECT * FROM RVIXarticle;
SELECT * FROM RVIXarticle WHERE id = 2 AND user = 2;

SELECT * FROM RVIXanswer;

SELECT * FROM RVIXarticlecomment;

SELECT * FROM RVIXanswercomment;

SELECT * FROM RVIXaccount;
DELETE FROM RVIXaccount WHERE id = 5;


SELECT * FROM RVIXtags;
SELECT * FROM RVIXtags ORDER BY tagcount DESC, tag LIMIT 5;
SELECT * FROM RVIXtags WHERE BINARY tag = BINARY 'ål';
SELECT SUM(tagcount) FROM RVIXtags;

SELECT * FROM RVIXarticleView;
SELECT * FROM RVIXanswerSumView;

SELECT * FROM RVIXanswerView;

SELECT * FROM RVIXarticlevotes;

SELECT * FROM RVIXarticlecommentvotes;

SELECT * FROM RVIXarticlecomment WHERE id = 3;

SELECT * FROM RVIXanswervotes;

SELECT * FROM RVIXanswercommentvotes;

SELECT * FROM RVIXanswer ORDER BY created DESC LIMIT 5;

-- ALTER TABLE RVIXanswer
-- ADD COLUMN accepted VARCHAR(10) DEFAULT 'no';

UPDATE RVIXaccount SET rank = 1;