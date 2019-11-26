# mongo-odm 

> mongodb的面向对象操作库

## Collection 集合

**`Collection`集合**的作用进行*数据*的增删改查,数据的载体时Document

## Document 文档
**`Document`文档**为数据的载体,文档的创建即在集合中增加,文档的删除即在集合中删除,文档的销毁就是文档对象的销毁,不在集合中进行操作

Document事件

| 事件 |内容 |是否可终止|
| --- | --- |--- |
| beforeCreate   | 创建前   |是|
| beforeSave   | 删除前   |是|
| afterFetch   | 删除前   |是|
| afterSave   | 删除前   |是|
| afterDelete   | 删除前   |是|
| afterDelete   | 删除前   |是|
| beforeDelete  | 删除后   |否|

