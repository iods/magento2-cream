set @STORE_TO_COPY_FROM = 2;
set @STORE_TO_COPY_TO = 3;

insert ignore into cms_block_store
select block_id, @STORE_TO_COPY_TO
from cms_block_store
where store_id = @STORE_TO_COPY_FROM;

insert ignore into cms_page_store
select page_id, @STORE_TO_COPY_TO
from cms_page_store
where store_id = @STORE_TO_COPY_FROM;