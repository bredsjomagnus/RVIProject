use RVIProject;

SELECT * FROM RVIXarticle WHERE tags LIKE '%rpg%';
SELECT * FROM RVIXarticle;

SELECT * FROM RVIXanswer;

SELECT * FROM RVIXarticlecomment;

SELECT * FROM RVIXanswercomment;

SELECT * FROM RVIXaccount;

SELECT * FROM RVIXtags;
SELECT * FROM RVIXtags ORDER BY tagcount DESC, tag LIMIT 5;
SELECT * FROM RVIXtags WHERE BINARY tag = BINARY 'ål';
SELECT SUM(tagcount) FROM RVIXtags;

SELECT * FROM RVIXarticleView;
SELECT * FROM RVIXanswerSumView;

SELECT * FROM RVIXanswerView;