//
//  ReportDataController.h
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import <Foundation/Foundation.h>
@class Report;

@interface ReportDataController : NSObject

@property (nonatomic, copy) NSMutableArray *masterReport;

- (NSUInteger) countOfMasterReport;
- (Report *)objectInMasterReportAtIndex:(NSUInteger)index;
- (void)addReport:(Report *)report;

@end
