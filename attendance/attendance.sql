SET names utf8;
SET FOREIGN_KEY_CHECKS=0;

DROP DATABASE IF EXISTS attendance;
CREATE DATABASE attendance CHARSET utf8;
USE attendance;
 
-- ----------------------------
-- Table structure for staff_info
-- ----------------------------
DROP TABLE IF EXISTS `staff_info`;
CREATE TABLE `staff_info` (
  `jobnum` int(255) NOT NULL COMMENT '工号',
  `name` varchar(255) default NULL COMMENT '姓名',
  `dept` varchar(255) default NULL COMMENT '部门',
  `depthead` varchar(255) default NULL COMMENT '部门领导'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
-- ----------------------------
-- Table structure for attend_record
-- ----------------------------
DROP TABLE IF EXISTS `attend_record`;
CREATE TABLE `attend_record` (
  `jobnum` int(255) NOT NULL COMMENT '工号',
  `number` int(255) NOT NULL COMMENT '考勤序号',
  `state` varchar(255) default NULL COMMENT '签到为通过否则为不通过'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for attend_score
-- ----------------------------
DROP TABLE IF EXISTS `attend_score`;
CREATE TABLE `attend_score` (
  `jobnum` int(255) NOT NULL COMMENT '工号',
  `sum_fail` int(255) NOT NULL COMMENT '累计签到次数',
  `score` int(255) NOT NULL COMMENT '考勤成绩'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for var
-- ----------------------------
DROP TABLE IF EXISTS `var`;
CREATE TABLE `var` (
  `sum_all` int(255) NOT NULL COMMENT '考勤次数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `var` (`sum_all`) VALUES (0);

-- ----------------------------
-- Records of staff_info
-- ----------------------------
INSERT INTO `staff_info` (`jobnum`, `name`, `dept`, `depthead`) VALUES
(2015040139, '林东辉', '秘书', '冯清莲'),
(2015040140, '王子建', '秘书', '冯清莲'),
(2015040141, '周晓梅', '人力资源', '于连'),
(2015040142, '李月鹏', '人力资源', '于连'),
(2015040143, '洪金宝', '公关', '陈建'),
(2015040144, '王福全', '公关', '陈建'),
(2015040145, '马冬梅', '公关', '陈建');

-- ----------------------------
-- Records of attend_score
-- ----------------------------
INSERT INTO `attend_score` (`jobnum`) VALUES
(2015040139),
(2015040140),
(2015040141),
(2015040142),
(2015040143),
(2015040144),
(2015040145);

-- ---------------------------------
-- Indexes for table `staff_info`
-- ---------------------------------
ALTER TABLE `staff_info`ADD PRIMARY KEY (`jobnum`);

-- ---------------------------------
-- Indexes for table `attend_score`
-- ---------------------------------
ALTER TABLE `attend_score`ADD PRIMARY KEY (`jobnum`);

-- ----------------------------
-- 在表attend_record上创建触发器change_score
-- 签到通过，score+1，
-- 累计考勤不通过数
-- ----------------------------
DELIMITER $$
DROP TRIGGER IF EXISTS change_score$$
CREATE TRIGGER change_score AFTER INSERT
   ON attend_record FOR EACH ROW
   BEGIN
      --  考勤通过者，score+1
      update attend_score 
      set score=score+'1' 
      where  jobnum=NEW.jobnum and NEW.state = '通过';
      -- 累计考勤不通过数
      update attend_score 
      set sum_fail=sum_fail+'1'
      where  jobnum=NEW.jobnum and NEW.state = '不通过';
   END
   $$
DELIMITER ;
