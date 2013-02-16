//
//  ReportDataController.h
//  peaceguard
//
//  Created by JonasYao on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>
@class Report;

@interface ReportDataController : NSObject

@property (nonatomic, copy) NSMutableArray *masterReport;

- (NSUInteger) countOfMasterReport;
- (Report *)objectInMasterReportAtIndex:(NSUInteger)index;
- (void)addReport:(Report *)report;

@end
