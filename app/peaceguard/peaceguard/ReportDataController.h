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

@property (nonatomic, copy) Report *theReport;

- (void) makeReportWithType: (NSString *) type severity: (NSString *) severity location: (NSString *) location time: (NSInteger *) time andDescription: (NSString *) description;
- (NSString *) getPOSTData: (NSString *) email;

@end
