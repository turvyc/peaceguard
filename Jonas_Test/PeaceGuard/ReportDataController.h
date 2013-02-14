//
//  ReportDataController.h
//  PeaceGuard
//
//  Created by JonasYao on 2013-02-13.
//  Copyright (c) 2013 JonasYao. All rights reserved.
//

#import <Foundation/Foundation.h>
@class Report;

@interface ReportDataController : NSObject

@property (nonatomic, copy) NSMutableArray *masterReport;

- (NSUInteger) countOfMasterReport;
- (Report *)objectInMasterReportAtIndex:(NSUInteger)index;
- (void)addReport:(Report *)report;

@end

