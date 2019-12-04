# mongo-odm 对象文档映射器

https://packagist.org/packages/phpmicroservice/mongo-odm

> mongodb的面向对象操作库,采用PHP对象和mongodb文档建立映射关系的方式达到对象操作数据库的目的

## Collection 集合

**`Collection`集合**的作用进行*数据*的增删改查,数据的载体时Document

## Document 文档
**`Document`文档**为数据的载体,文档的创建即在集合中增加,文档的删除即在集合中删除,文档的销毁就是文档对象的销毁,不在集合中进行操作

Document事件 Event

| 事件 |内容 |是否可终止|
| --- | --- |--- |
| afterFetch   | 读取后   |否|
| beforeCreate   | 新建前   |是|
| afterCreate | 新建后 | 否 |
| beforeSave   | 修改前   |是|
| afterSave   | 修改  |否|
| beforeDelete  | 删除前   |是|
| afterDelete   | 删除后   |否|


