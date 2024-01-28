-- Although the problem was solved using OOP inside the code, this could be used as an alternative using only SQL to retrieve the next show.
-- Could be made into a procedure for example, and called inside the aplication to retrieve the raw data.
-- This was just made as an extra and is in no way part of the aplication!

SET collation_connection = 'utf8mb4_unicode_ci';

set @WeekDayID = 6;
set @ShowTime = '23:00:00';
set @TvSeriesTitle = '';

SELECT * FROM (
	(
		SELECT * FROM (
			SELECT id_tv_series_id, week_day, show_time, 1 AS filter,
			CASE
				WHEN week_Day= 'Sunday' THEN 1
				WHEN week_Day= 'Monday' THEN 2
				WHEN week_Day= 'Tuesday' THEN 3
				WHEN week_Day= 'Wednesday' THEN 4
				WHEN week_Day= 'Thursday' THEN 5
				WHEN week_Day= 'Friday' THEN 6
				WHEN week_Day= 'Saturday' THEN 7
			END AS week_day_id
			FROM tv_series_intervals
		) AS tbl1 
		INNER JOIN tv_series ON tv_series.id = tbl1.id_tv_series_id 
		WHERE (
			(week_day_id = @WeekDayID AND show_time >= @ShowTime)
			OR week_day_id > @WeekDayID
		)
		AND title LIKE CONCAT('%', @TvSeriesTitle, '%')
		ORDER BY week_day_id, show_time
	)
	
	UNION ALL

	SELECT * FROM (
		SELECT id_tv_series_id, week_day, show_time, 2 AS filter,
		CASE
			WHEN week_Day= 'Sunday' THEN 1
			WHEN week_Day= 'Monday' THEN 2
			WHEN week_Day= 'Tuesday' THEN 3
			WHEN week_Day= 'Wednesday' THEN 4
			WHEN week_Day= 'Thursday' THEN 5
			WHEN week_Day= 'Friday' THEN 6
			WHEN week_Day= 'Saturday' THEN 7
		END AS week_day_id
		from tv_series_intervals
	) AS tbl2 
	INNER JOIN tv_series ON tv_series.id = tbl2.id_tv_series_id 
	WHERE week_day_id <= @WeekDayID
	AND title LIKE CONCAT('%', @TvSeriesTitle, '%')
	ORDER BY week_day_id, show_time

) AS results
ORDER BY filter
LIMIT 1