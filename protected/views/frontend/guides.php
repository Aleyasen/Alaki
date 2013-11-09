<p align="center">
    <strong>Group Detection Algorithms</strong>
</p>
<p align="center">
    <strong></strong>
</p>

<p>
    In this application, you will create different groupings of your Facebook network by using 3 group detection (clustering) algorithms. Each algorithm
    organizes your groups in a different way:
</p>
<p>
    <strong>Disjoint Clustering</strong>
</p>
<p>
    - Each friend belongs to exactly one group.
</p>
<p align="center">
    <img width="600" src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/Disjoint.jpg' />
</p>
<p>
    <strong>Overlapping Clustering</strong>
</p>
<p>
    - Each friend can belong to more than one group.
</p>
<p align="center">
    <img width="500"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/Overlapping.jpg'/>
</p>
<p>
    <strong>Hierarchical Clustering</strong>
</p>
<p>
    - The detected groups (i.e. micro groups) can be a sub-group of a larger group.
</p>
<p>
    - Each friend belongs to exactly one micro group.
</p>
<p align="center">
    <img width="500"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/Hier.jpeg'/>
</p>
<p align="center">
    <strong></strong>
</p>
<br>
<br>
<p align="center">
    <strong>Instructions to Use the Application </strong>
</p>
<p align="center">
    <strong></strong>
</p>
<p>
    After creating a group structure by an algorithm, you can see the groups of your friends on the left side panel. For each kind of algorithm, there is a tab
    which you can click on it to start working on its group structure. By clicking on each group, you can see its members in the central panel.
</p>
<p align="center">
    <img width="700"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/1.jpg'/>
</p>
<p>
    The last group which is named <em>‘un-grouped’</em> contains the friends that the algorithm cannot find any appropriate group for them.
</p>
<p align="center">
    <img width="700"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/2.jpg'/>
</p>
<p>
    You can revise the created groups of an algorithm by the following steps:
</p>
<p>
    1. First look over each group and label it by considering what at least 2/3 of members mean.
</p>
<p>
    - If you are not sure who is a specific friend, you can hover it and click on the small FB icon to see his/her FB page.
</p>
<p align="center">
    <img width="700"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/3.jpg'/>
</p>
<p>
    2. If a group does not have any meaning for you, you can just delete it by clicking on the close sign of it. Its members will be automatically moved to
    ‘un-grouped’ group.
</p>
<p>
    3. If you think the current group has the same concept with one of the previous groups, you can <em>select all</em> its members and drag to the other group
    to merge them. Then, delete the current group.
</p>
<p>
    4. After finishing labeling all groups, you can come back to the first and try to make each group perfect:
</p>
<p>
    a. If a member does not belong to this group and you cannot find any other group for it, delete it. It will be automatically moved to ‘un-grouped’ group.
</p>
<p align="center">
    <img width="700"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/4.jpg'/>
</p>
<p>
    b. If a member belongs to another group, you can drag and drop it to that group.
</p>
<p align="center">
    <img width="700"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/5.jpg'/>
</p>
<p>
    c. If there are some members that you think belongs to a group that is not listed in the groups list, you can create a new group by ‘Add Group’ bottom.
    Then, you can select those members from one or more groups and move to the new group.
</p>
<p align="center">
    <img width="500"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/add.jpg'/>
</p>
<p>
    5. After reviewing all the groups, you can check the ‘un-grouped’ group too which contains the members the algorithm cannot group them or the members you
    deleted before. If you cannot find any group for a member of this group, just leave it there.
</p>
<p>
    6. When you finish all of your groupings from different algorithms, you can click on 'Finish' button to save and exit. Then, you can logout the application
    by 'logout' button.
</p>
<p>
    <em>Some Tips</em>
</p>
<p>
    - Overlapping Clustering: In this algorithm, when you drag and drop a member of a group to another group, it will not be removed from the original group as
    a member can belong to more than one group.
</p>
<p>
    - Hierarchical Clustering: <a name="_GoBack"></a>In this algorithm, if two or more groups belong to a high level group, these groups will be aggregated in
    one group as can be seen here:
</p>
<p align="center">
    <img width="700"  src='<?php echo Yii::app()->request->baseUrl; ?>/images/guide/6.jpg'/>
</p>